[news]
<script type="text/javascript">
    var page_cnt = 1;
    $(document).ready(function () {
        $('#wall_text, .fast_form_width').autoResize();
        $(window).scroll(function () {
            if ($(document).height() - $(window).height() <= $(window).scrollTop() + ($(document).height() / 2 - 250)) {
                news.page();
            }
        });
    });
    $(document).click(function (event) {
        wall.event(event);
    });
</script>
<style>
    .newcolor000{color:#000} .audio_onetrack, .player_mini_mbar

    {width:760px}
</style>
<div id="jquery_jplayer"></div>
<input type="hidden" id="teck_id" value=""/>
<input type="hidden" id="teck_prefix" value=""/>
<input type="hidden" id="typePlay" value="standart"/>
<input type="hidden" id="type" value="{type}"/>
<div class="buttonsprofile">
    <div class="{activetab-}"><a href="/news" onClick="Page.Go(this.href); return false;">
            <div>Новости</div>
        </a></div>
    <div class="{activetab-notifications}"><a href="/news/notifications" onClick="Page.Go(this.href); return false;">
            <div>Ответы</div>
        </a></div>
    <div class="{activetab-photos}"><a href="/news/photos" onClick="Page.Go(this.href); return false;">
            <div>Фотографии</div>
        </a></div>
    <div class="{activetab-videos}"><a href="/news/videos" onClick="Page.Go(this.href); return false;">
            <div>Видеозаписи</div>
        </a></div>
    <div class="{activetab-updates}"><a href="/news/updates" onClick="Page.Go(this.href); return false;">
            <div>Обновления</div>
        </a></div>
</div>
<div class="clear"></div>[/news]
[bottom]<span id="news"></span>
[bottom]<span id="news"></span>
<div onClick="news.page()" id="wall_l_href_news" class="cursor_pointer">
    <div class="doc_all_but border_radius_5" id="loading_news">Показать предыдущие новости</div>
</div>[/bottom]