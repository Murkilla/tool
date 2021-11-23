<?php
set_time_limit(0);

header("Content-Type:text/html; charset=utf-8");
require_once $this->config->path_lib.'/uploadAction.ini.php';
require_once $this->config->path_lib.'/PHPExcel.php';
require_once $this->config->path_mysql;

$type = isset($this->io->input['post']['type']) && !empty($this->io->input['post']['type']) ? $this->io->input['post']['type'] : '';
$clear = isset($this->io->input['post']['clear']) && !empty($this->io->input['post']['clear']) ? $this->io->input['post']['clear'] : '';

if($clear == 'clear'){
    $log = clearLastData();
    echo json_encode(msg('清除成功!!',$log));
    exit();
}

if($type == 'sub_only'){
    $date = array('start' => $this->io->input['post']['startdate'],'end' => $this->io->input['post']['enddate']);
    $arr = getDataFromTrust($date);
    $log = insertDataTo55($arr);
    echo json_encode(msg('新增成功!!',$log));
    exit();
}

if(!empty($this->io->input['files']['files'])){

    // 重新建構上傳檔案 array 格式
    $files = getFiles($this->io->input['files']);

    $arr = array();
    // 依上傳檔案數執行
    foreach ($files as $fileInfo) {
        // 呼叫封裝好的 function
        $res = uploadFile($fileInfo,array('csv','xlsx'),52428800,false,'./upload');
        
        // 顯示檔案上傳錯誤訊息
        if(!empty($res['mes'])){
            echo json_encode(msg("check console.log",$res['mes']));
            exit();
        }
        // 上傳成功，將實際儲存檔名存入 array（以便存入資料庫）
        if (!empty($res['dest'])) {
            $arr = getImportData($res['dest'],$res['info']);
        }     
    }
    if($type == 'sub'){
        $newArr = resetDataByType($arr);
        $newArr = getDataFrom108($newArr);
        $log = insertDataTo55($newArr);
    }else if($type == 'main'){
        $newArr = resetDataByType($arr);
        $newArr = resetDataFormat($newArr);
        $log = insertDataTo55($newArr);
    }else if($type == 'main_only'){
        unset($arr[0]);
        $arr = array_values($arr);
        $newArr = resetTrustData($arr);
        $log = insertDataTo55($newArr);
    }
    echo json_encode(msg('新增成功!!',$log));
    exit();
}else{
    echo json_encode(msg('請選擇檔案!!',$log));
    exit();
}
//取得excel或csv檔案中資料
function getImportData($path,$name){
    if(empty($path) || !isset($path)){
        echo json_encode(msg('資料異常！！','upload path error!!!'));
        exit();
    }

    if(explode('.',$name)[1] == 'xlsx'){
        $fileType = "Excel2007";
    }else{
        $fileType = "CSV";
    }

    $objReader = PHPExcel_IOFactory::createReader($fileType);
    $objPHPExcel = $objReader->load($path);
    $objWorksheet = $objPHPExcel->getActiveSheet();
    
    $arr = array();
    foreach ($objWorksheet->getRowIterator() as $row) {
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set

        foreach ($cellIterator as $key => $cell) {
            $arr[$row->getRowIndex()-1][$key] = $cell->getValue();
        }
    }
    return $arr;
}
// 區分買賣方資料
function resetDataByType($arr){
    $newArr = array();
    $newArr['buy'] = $newArr['sell'] = array();
    for($i=0;$i<count($arr);$i++){
        if($arr[$i][2] == '買方' || $arr[$i][4] == '成交買方'){
            array_push($newArr['buy'],$arr[$i]);
        }else if($arr[$i][2] == '賣方' || $arr[$i][4] == '成交賣方'){
            array_push($newArr['sell'],$arr[$i]);
        }
    }
    return $newArr;
}
// 加盟 買賣方
function getDataFrom108($arr){
    //require_once $this->config->path_lib.'/mysql.ini.php';
    $model = new mysql();
    $model->host = '10.10.1.108';
    $model->user = 'nhg';
    $model->password = '@nhg';
    $model->dbName = 'TWHOUSE';
    $model->connect();


    $buy = $sell = '';
    for($i=0;$i<count($arr['buy']);$i++){
        if(strlen($buy) > 1){
            $buy .= ',';
        }
        $buy .= "'".str_replace('_','',$arr['buy'][$i][0])."'";
    }

    for($i=0;$i<count($arr['sell']);$i++){
        if(strlen($sell) > 1){
            $sell .= ',';
        }
        $sell .= "'".str_replace('_','',$arr['sell'][$i][0])."'";
    }
    if(!empty($buy)){
        $query = "
        SELECT 
            '加盟' AS '店類別', '買方' AS '買賣方', IF(SUBSTR(BUYER_ID_NO, 2, 1)='1', '男', '女') AS '性別', p.BUYER_NAM AS '客戶姓名', p.BUYER_TEL_CON_1 AS '客戶電話', 	a.STID AS '店編號', a.STME AS '店名', p.SALE_NO AS '員編', p.SALE_NAM AS '員工姓名', a.AG_MOBILE AS '員工手機', p.NOTE_NO AS '物件編號', '0' as 'status', '0' as 'is_can_draw', p.CERTIFIEDID AS '建經保證碼'
        FROM payptdef p 
            LEFT JOIN AG01 AS a ON p.SALE_NO=a.AGID 
            LEFT JOIN ST01 AS s ON s.STID=a.STID 
        WHERE 1
            AND p.MONEY_ITEM IN ('1','6')
            AND p.recheck IN ('Y')
            AND p.BUY_CHARGE > 0
            AND p.CERTIFIEDID IN (".$buy.")
        ";
        $buyArr = $model->getQueryRecord($query);
    }
    if(!empty($sell)){
        $query = "
        SELECT 
            '加盟' AS '店類別', '賣方' AS '買賣方', IF(SUBSTR(SELLER_ID_NO, 2, 1)='1', '男', '女') AS '性別', p.SELLER_NAM AS '客戶姓名', p.SELLER_TEL_CON_1 AS '客戶電話', 	a.STID AS '店編號', a.STME AS '店名', p.SALE_NO AS '員編', p.SALE_NAM AS '員工姓名', a.AG_MOBILE AS '員工手機', p.NOTE_NO AS '物件編號', '0' as 'status', '0' as 'is_can_draw', p.CERTIFIEDID AS '建經保證碼' 
        FROM payptdef p
            LEFT JOIN AG01 AS a ON p.SALE_NO=a.AGID 
            LEFT JOIN ST01 AS s ON s.STID=a.STID 
        WHERE 1
          AND p.MONEY_ITEM IN ('1','6')
          AND p.recheck IN ('Y')
          AND p.SALE_CHARGE > 0
          AND p.CERTIFIEDID IN (".$sell.");
        ";
        $sellArr = $model->getQueryRecord($query);
    }
    $table['table']['record'] = array_merge($buyArr['table']['record'],$sellArr['table']['record']);
    return $table;
}
// 加盟 專任委託
function getDataFromTrust($date){
    if(empty($date['start']) && empty($date['end'])){
        echo json_encode(msg('開始或結束日期有誤!!','專任委託開始結束時間有誤'));
        exit();
    }
    $start = $date['start'];
    $end = $date['end'];

   // require_once $this->config->path_lib.'/mysql.ini.php';
    $model = new mysql();
    $model->host = '10.10.1.108';
    $model->user = 'nhg';
    $model->password = '@nhg';
    $model->dbName = 'TWHOUSE';
    $model->connect();

    $query = "
    SELECT 
        '加盟' AS '店類別', '專任' AS '買賣方' , IF(p.SEX='1', '男', '女') AS '性別', B.CONTACT_NAM AS '客戶姓名', B.CONTACT_TEL_CON AS '客戶電話',  f.DEP_ID AS '店編號', f.DEP_NAM AS '店名', f.EMP_NO AS '員編', f.EMP_NAM AS '員工姓名', a.AG_MOBILE AS '員工手機', f.NOTE_NO AS '物件編號', '0' as 'status', '0' as 'is_can_draw'
    FROM formstock AS f 
        LEFT JOIN slif011 AS B ON f.NOTE_NO = B.NOTE_NO
        LEFT JOIN formconsent AS fs ON f.NOTE_NO = fs.NOTE_NO 
        LEFT JOIN AG01 AS a ON f.EMP_NO=a.AGID 
        LEFT JOIN ST01 AS s ON s.STID=a.STID 
        LEFT JOIN PDA03 AS p ON f.NOTE_NO = p.NOTE_NO 
    WHERE 
        f.EMP_NO!='' AND f.ALIVE='Y'
        AND ((f.STA_DAT BETWEEN '".$start."' AND '".$end."' AND TIMESTAMPDIFF(MONTH, f.STA_DAT, f.END_DAT) >= 3) OR 
        (fs.END_DAT BETWEEN '".$start."' AND '".$end."' AND TIMESTAMPDIFF(MONTH, fs.END_DAT, fs.DATE) >= 3))
        AND f.FORM_KIND_ID = '01' 
        AND f.CASE_NAM <> ''
        AND f.DEP_ID <> 'T000'
        AND B.KIND_ID = '1'
    ORDER BY f.END_DAT DESC;     
    ";
    $table = $model->getQueryRecord($query);
    return $table;
}
// 直營 成交買賣方
function resetDataFormat($arr){
    $table['table']['record'] = array();
    for($i=0;$i<count($arr['buy']);$i++){
        if(preg_match('/^[A-Z]{1}/',$arr['buy'][$i][2])){
            if(substr($arr['buy'][$i][2],1,1) == '1'){
                $sex = '男';
            }else{
                $sex = '女';
            }
        }else{
            $sex = '男';
        }
        $tmp = array(
            '店類別' => '直營',
            '買賣方' => $arr['buy'][$i][4],
            '性別' => $sex,
            '客戶姓名' => $arr['buy'][$i][5],
            '客戶電話' => $arr['buy'][$i][6],
            '店編號' => $arr['buy'][$i][7],
            '店名' => $arr['buy'][$i][8],
            '員編' => $arr['buy'][$i][11],
            '員工姓名' => $arr['buy'][$i][12],
            '員工手機' => $arr['buy'][$i][13],
            '物件編號' => $arr['buy'][$i][9],
            'status' => '0',
            'is_can_draw' => '0',
        );
        array_push($table['table']['record'],$tmp);
    }
    for($i=0;$i<count($arr['sell']);$i++){
        if(preg_match('/^[A-Z]{1}/',$arr['sell'][$i][2])){
            if(substr($arr['sell'][$i][2],1,1) == '1'){
                $sex = '男';
            }else{
                $sex = '女';
            }
        }else{
            $sex = '男';
        }
        $tmp = array(
            '店類別' => '直營',
            '買賣方' => $arr['sell'][$i][4],
            '性別' => $sex,
            '客戶姓名' => $arr['sell'][$i][5],
            '客戶電話' => $arr['sell'][$i][6],
            '店編號' => $arr['sell'][$i][7],
            '店名' => $arr['sell'][$i][8],
            '員編' => $arr['sell'][$i][11],
            '員工姓名' => $arr['sell'][$i][12],
            '員工手機' => $arr['sell'][$i][13],
            '物件編號' => $arr['sell'][$i][9],
            'status' => '0',
            'is_can_draw' => '0',
        );
        array_push($table['table']['record'],$tmp);
    }
    return $table;
}
// 直營 專任委託
function resetTrustData($arr){
    $table['table']['record'] = array();
    for($i=0;$i<count($arr);$i++){
        if(preg_match('/^[A-Z]{1}/',$arr[$i][2])){
            if(substr($arr[$i][2],1,1) == '1'){
                $sex = '男';
            }else{
                $sex = '女';
            }
        }else{
            $sex = '男';
        }
        $tmp = array(
            '店類別' => '直營',
            '買賣方' => $arr[$i][4],
            '性別' => $sex,
            '客戶姓名' => $arr[$i][5],
            '客戶電話' => $arr[$i][6],
            '店編號' => $arr[$i][7],
            '店名' => $arr[$i][8],
            '員編' => $arr[$i][11],
            '員工姓名' => $arr[$i][12],
            '員工手機' => $arr[$i][13],
            '物件編號' => $arr[$i][9],
            'status' => '0',
            'is_can_draw' => '0',
        );
        array_push($table['table']['record'],$tmp);
    }
    return $table;
}
//匯入資料至DB
function insertDataTo55($arr){
    //require_once $this->config->path_lib.'/mysql.ini.php';
    $model = new mysql();
    $model->host = '10.10.1.55';
    $model->user = 'twhg';
    $model->password = 'twPagAlex55';
    $model->dbName = 'www';
    $model->connect();

    $sub_query = '';
    foreach($arr['table']['record'] as $k => $v){
        if(strlen($sub_query) > 0){
            $sub_query .= ',';
        }
        $sub_query .= "(".
                    "'".$v['店類別']."',".
                    "'".$v['買賣方']."',".
                    "'".$v['性別']."',".
                    "'".$v['客戶姓名']."',".
                    "'".$v['客戶電話']."',".
                    "'".$v['店編號']."',".
                    "'".$v['店名']."',".
                    "'".$v['員編']."',".
                    "'".$v['員工姓名']."',".
                    "'".$v['員工手機']."',".
                    "'".$v['物件編號']."',".
                    "'".$v['status']."',".
                    "'".$v['is_can_draw']."'".
                    ")";
    }
    $query = "
    INSERT IGNORE INTO `gogoro_draw`
    (
        `org`,
        `dataFrom`,
        `sex`, 
        `name`,
        `phone`,
        `sid`,
        `sname`,
        `uid`,
        `uname`,
        `uphone`,
        `oid`,
        `status`,
        `is_can_draw`
    )";
     $query .= 'VALUE';
     $query .= $sub_query;
    echo json_encode(msg("check console.log",$query));
    exit();
    $model->query($query);
    return $query;
}
// 清除上次抽獎資料
function clearLastData(){
    //require_once $this->config->path_lib.'/mysql.ini.php';
    $model = new mysql();
    $model->host = '10.10.1.55';
    $model->user = 'twhg';
    $model->password = 'twPagAlex55';
    $model->dbName = 'www';
    $model->connect();
    
    $query = "
        SELECT
            MAX(is_can_draw) as max
        FROM
            `gogoro_draw`
        WHERE
            1
    ";
    $max = $model->getQueryRecord($query);
    $max = $max['table']['record'][0]['max'] + 1;

    $query = "
        UPDATE
            `gogoro_draw`
        SET
            `is_can_draw` = '".$max."',
            `setCantDrawTime` = NOW()
        WHERE
            `is_can_draw` = '0'
    ";
    echo json_encode(msg("check console.log",$query));
    exit();
    $model->query($query);
    return $query;
}
function msg($msg,$log){
    $response = array(
        'success' => true,
        'msg' => $msg,
        'log' => $log
    );
    return $response;
}
