<?php
/**
 * 如何统计用户访问当前网站的时间？+关掉当前网页.
 */
function closeSite()
{
    echo '<script>window.close();</script>';
}

/**
 * window.close()报错"Scripts may close only the windows that were opened by it."
 * 所以使用跳转的方式；.
 */
function redirectSite()
{
    echo "<script>window.setTimeout(function(){location.href = 'https://www.google.com/?gws_rd=ssl';},100);</script>";
}

/*
 * 统计用户访问当前网站的时间
 * @link [php - 如何统计用户在某个页面的停留时长呢？ - SegmentFault 思否](https://segmentfault.com/q/1010000000500929)
 *
 */
