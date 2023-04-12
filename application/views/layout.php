<?php

defined('BASEPATH') or exit('No direct script access allowed');



$this->load->view($folder . '/includes/header');

$this->load->view($folder . '/' . $template);

$this->load->view($folder . '/includes/footer');
