<div class="onevideo page_bg border_radius_5" id="video_{id}" style="padding-top:20px;padding-bottom:15px">
    <a href="/video{user-id}_{id}" onClick="videos.show({id}, this.href); return false">
        <div class="onevideo_img"><img src="{photo}" alt=""/></div>
    </a>
    <div class="onevideo_title"><a href="/video{user-id}_{id}" id="video_title_{id}"
                                   onClick="videos.show({id}, this.href); return false">{title}</a></div>
    <div class="onevideo_inf2" id="video_descr_{id}">{descr}</div>
    <div class="onevideo_inf">{comm}</div>
    <div class="onevideo_inf">Добавлено {date}</div>
    [owner]
    <div class="onevideo_inf"><a href="/" onClick="videos.editbox({id}); return false">Редактировать</a>
        <a href="/" class="fl_r" onClick="videos.delet({id}); return false">Удалить</a>
    </div>
    [/owner]
    <input type="hidden" value="{id}" id="onevideo"/>
    <div class="clear"></div>
</div>
<div class="clear"></div>