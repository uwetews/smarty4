<?php
class Smarty_Resource_Ioncube extends Smarty_Resource_Source_File
{
    public function getTemplateSource($_template)
    {
        // read template file
        if (file_exists($_template->getTemplateFilepath())) {
            var_dump('dddadadda');
            if (function_exists('ioncube_read_file')) {
                $res = ioncube_read_file($_template->getTemplateFilepath());
                if (is_int($res)) return false;
                $_template->template_source = $res;

                return true;
            } else {
                $_template->template_source = file_get_contents($_template->getTemplateFilepath());

                return true;
            }
        } else {
            return false;
        }
    }
}
