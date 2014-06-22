<?php

require_once(getenv("DOCUMENT_ROOT") . "/neu/mods/_class/allgemein/allgemein.variablen.php5");

/**
Info
 */

function smarty_block_info($params, $content, &$smarty, &$repeat)
{

    if (empty($params["infotext"])) {
        $params["infotext"] = null;
    }

    if (empty($params["title"])) {
        $params["title"] = null;
    }

    $titel = (!empty($params["titel"])) ? $params["titel"] : $params["title"];
    $info = (!empty($params["text"])) ? $params["text"] : $params["infotext"];

    if (!isset($params['image'])) {
        $params['image'] = true;
    }

    if (empty($params["width"]) && !empty($params["breite"])) {
        $params["width"] = $params["breite"];
    }

    if (empty($params["height"]) && !empty($params["hoehe"])) {
        $params["height"] = $params["hoehe"];
    }

    if (empty($params["width"]) && !empty($params["link"])) {
        $params["width"] = 500;
    }

    if (empty($params["class"])) {
        $params["class"] = "wmtt_hinweis";
    }

    if (empty($params["height"])) {
        $params["height"] = 600;
    }

    if (empty($js)) {
        $js = null;
    }

    if (!empty($params["link"])) {

        $js = "onclick=\"startPopUp('" . $params["link"] . "','width=" . $params["width"] . ", height=" . $params["height"] . ", scrollbars=yes',false)\" ";
        $cursor = "cursor:pointer;cursor:hand;";
    }

    if ($content != "") {
        $zufall = "div_" . rand(1000000000, 9999999999);
        $js .= " onmouseover=\"showWMTT('$zufall')\" onmouseout=\"hideWMTT()\" ";
    }

    if (!empty($params["anzeigebild"])) {
        $imageurl = $params["anzeigebild"];
    } else {

        if (!empty(Vars::$Vermittler->nummer)) {

            Vars::$Vermittler->loadRechnerEinstellungen();
            if (Vars::$Vermittler->rechner['info'] != "") {
                $grafik = Vars::$Vermittler->rechner['info'];
            } else {
                $grafik = "_defaulti.png";
            }
        } else {
            $grafik = "_defaulti.png";
        }

        $imageurl = BlauPage::getPathRoot() . 'data/rechnerpics/' . $grafik;
    }

    if ($params['image'] !== true) {
        $out = '<img title=\'' . addslashes($info) . '\' ' . $js . ' src=\'' . $imageurl . '\' alt=\'i\' style=\'float:right; padding-left: 5px; padding-top: 2px; ' . $cursor . '	\' />';
    } else {

        if (empty($cursor)) {
            $cursor = null;
        }

        $out = '<img title=\'' . addslashes($info) . '\' ' . $js . ' src=\'' . $imageurl . '\' alt=\'i\' style=\'' . $cursor . '	\' />';
    }

    if (!empty($content)) {

        if (!empty($params["width"])) {
            $params["width"] = 'width: ' . $params['width'] . 'px;';
        } else {
            $params["width"] = '';
        }

        $out .= '<div id=\'' . $zufall . '\' class=\'' . $params["class"] . '\' style=\'position:absolute;display:none;z-index:99;' . $params["width"] . '\'>' . "\n";
        $out .= trim($content) . "\n";
        $out .= '</div>' . "\n";
    }

    return $out;
}
