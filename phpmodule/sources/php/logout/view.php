<?php
session_destroy();
header("location:".$this->config->default_main."/login");
