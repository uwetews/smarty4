<?php
function smarty_postfilter_trimwhitespace($source, &$smarty)
{
    // Pull out the script blocks
    preg_match_all("!<script[^>]+>.*?</script>!is", $source, $match);
    $_script_blocks = $match[0];
    $source = preg_replace("!<script[^>]+>.*?</script>!is",
        '@@@SMARTY:TRIM:SCRIPT@@@', $source);

    // Pull out the pre blocks
    preg_match_all("!<pre>.*?</pre>!is", $source, $match);
    $_pre_blocks = $match[0];
    $source = preg_replace("!<pre>.*?</pre>!is",
        '@@@SMARTY:TRIM:PRE@@@', $source);

    // Pull out the textarea blocks
    preg_match_all("!<textarea[^>]+>.*?</textarea>!is", $source, $match);
    $_textarea_blocks = $match[0];
    $source = preg_replace("!<textarea[^>]+>.*?</textarea>!is",
        '@@@SMARTY:TRIM:TEXTAREA@@@', $source);

    // Pull out the input blocks
    preg_match_all("!<input[^>]+?/>!is", $source, $match);
    $_input_blocks = $match[0];
    $source = preg_replace("!<input[^>]+?/>!is",
        '@@@SMARTY:TRIM:INPUT@@@', $source);

    // Pull out the select blocks
    preg_match_all("!<select[^>]+>.*?</select>!is", $source, $match);
    $_input_select = $match[0];
    $source = preg_replace("!<select[^>]+>.*?</select>!is",
        '@@@SMARTY:TRIM:SELECT@@@', $source);

    // Pull out the php blocks
    preg_match_all("/<\?php.*?\?>(?:[\n\r]{1,2})?/s", $source, $match);
    $_Code_Php_blocks = $match[0];
    $source = preg_replace("/<\?php.*?\?>(?:[\n\r]{1,2})?/s",
        '@@@SMARTY:TRIM:PHP@@@', $source);

    // remove all leading spaces, tabs and carriage returns
    $source = trim(preg_replace(array('/[\n\r]+/m', '/[\s]{2,}/m'), array('', ' '), $source));

    // replace php blocks
    smarty_postfilter_trimwhitespace_replace("@@@SMARTY:TRIM:PHP@@@", $_Code_Php_blocks, $source);

    // replace select blocks
    smarty_postfilter_trimwhitespace_replace("@@@SMARTY:TRIM:SELECT@@@", $_input_select, $source);

    // replace input blocks
    smarty_postfilter_trimwhitespace_replace("@@@SMARTY:TRIM:INPUT@@@", $_input_blocks, $source);

    // replace textarea blocks
    smarty_postfilter_trimwhitespace_replace("@@@SMARTY:TRIM:TEXTAREA@@@", $_textarea_blocks, $source);

    // replace pre blocks
    smarty_postfilter_trimwhitespace_replace("@@@SMARTY:TRIM:PRE@@@", $_pre_blocks, $source);

    // replace script blocks
    smarty_postfilter_trimwhitespace_replace("@@@SMARTY:TRIM:SCRIPT@@@", $_script_blocks, $source);

    return $source;
}

function smarty_postfilter_trimwhitespace_replace($search_str, $replace, &$subject)
{
    $_len = strlen($search_str);
    $_pos = 0;
    for ($_i = 0, $_count = count($replace); $_i < $_count; $_i++)
        if (($_pos = strpos($subject, $search_str, $_pos)) !== false)
            $subject = substr_replace($subject, $replace[$_i], $_pos, $_len);
        else
            break;

}
