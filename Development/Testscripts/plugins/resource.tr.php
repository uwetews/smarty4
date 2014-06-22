<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     resource.db.php
 * Type:     resource
 * Name:     db
 * Purpose:  Fetches templates from a database
 * -------------------------------------------------------------
 */
function smarty_resource_tr_source($tpl_name, &$tpl_source, &$smarty)
{
    // do database call here to fetch your template,
    // populating $tpl_source
//        $tpl_source = '{include file="db:dbtest"}';
    $tpl_source = $tpl_name;

    return true;
}

function smarty_resource_tr_timestamp($tpl_name, &$tpl_timestamp, &$smarty)
{
    // $tpl_timestamp.
    $tpl_timestamp = (int) floor(time() / 100) * 100;

    return true;
}

function smarty_resource_tr_secure($tpl_name, &$smarty)
{
    // assume all templates are secure
    return true;
}

function smarty_resource_tr_trusted($tpl_name, &$smarty)
{
    // not used for templates
}
