<?php if (!empty($this->tplVar['page']['page']['item'])) :?>
<ul id="pager">
	<li>第<?php echo $this->tplVar['page']['thispage']; ?>頁&nbsp;</li>
	<li>資料共<?php echo $this->tplVar['page']['total']; ?>筆</li>
	<li class="splitter"></li>
	<li><a data-url="<?php echo $this->tplVar['status']['path']; ?>" data-arg="<?php echo $this->tplVar['status']['search_path'].$this->tplVar['status']['sort_path'];?>&p=<?php echo $this->tplVar['page']['firstpage'];?>" href="<?php echo $this->tplVar["status"]["path"] ?><?php echo $this->tplVar["status"]["search_path"] ;?><?php echo $this->tplVar["status"]["sort_path"] ;?>&p=<?php echo $this->tplVar['page']['firstpage'] ?>">最前頁</a></li>
	<li class="splitter"></li>
	<li><a data-url="<?php echo $this->tplVar['status']['path']; ?>" data-arg="<?php echo $this->tplVar['status']['search_path'].$this->tplVar['status']['sort_path'];?>&p=<?php echo $this->tplVar['page']['previouspage'];?>" href="<?php echo $this->tplVar["status"]["path"] ?><?php echo $this->tplVar["status"]["search_path"] ;?><?php echo $this->tplVar["status"]["sort_path"] ;?>&p=<?php echo $this->tplVar['page']['previouspage'] ?>">上一頁</a></li>
	<li class="splitter"></li>
	<li>&nbsp;[&nbsp;</li>
	<li>
        <?php foreach ($this->tplVar['page']['page']['item'] as $item) : ?>
				<a data-url="<?php echo $this->tplVar['status']['path'];?>" data-arg="<?php echo $this->tplVar['status']['search_path'].$this->tplVar['status']['sort_path'];?>&p=<?php echo $item['p'];?>" href="<?php echo $this->tplVar["status"]["path"] ?><?php echo $this->tplVar["status"]["search_path"] ;?><?php echo $this->tplVar["status"]["sort_path"] ;?>&p=<?php echo $item['p']; ?>"><?php echo $item['p']; ?></a>
        <?php endforeach; ?>
	</li>
	<li>&nbsp;]&nbsp;</li>
	<li class="splitter"></li>
	<li><a data-url="<?php echo $this->tplVar['status']['path']; ?>" data-arg="<?php echo $this->tplVar['status']['search_path'].$this->tplVar['status']['sort_path'];?>&p=<?php echo $this->tplVar['page']['nextpage'];?>" href="<?php echo $this->tplVar["status"]["path"] ?><?php echo $this->tplVar["status"]["search_path"] ;?><?php echo $this->tplVar["status"]["sort_path"] ;?>&p=<?php echo $this->tplVar['page']['nextpage'] ?>">下一頁</a></li>
	<li class="splitter"></li>
	<li><a data-url="<?php echo $this->tplVar['status']['path']; ?>" data-arg="<?php echo $this->tplVar['status']['search_path'].$this->tplVar['status']['sort_path'];?>&p=<?php echo $this->tplVar['page']['lastpage'];?>" href="<?php echo $this->tplVar["status"]["path"] ?><?php echo $this->tplVar["status"]["search_path"] ;?><?php echo $this->tplVar["status"]["sort_path"] ;?>&p=<?php echo $this->tplVar['page']['lastpage'] ?>">最後頁</a></li>
</ul>
<?php endif; ?>
