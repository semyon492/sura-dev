<div id="video_show_{vid}" class="video_view" onClick="videos.setEvent(event, {owner-id}, '{close-link}')">
    <div class="photo_close" onClick="videos.close({owner-id}, '{close-link}'); return false"></div>
    <div class="video_show_bg">
        <div class="video_show_object">
            <div class="video_show_title">
                <span id="video_full_title_{vid}">{title}</span>
                <div><a href="/" onClick="videos.close({owner-id}, '{close-link}'); return false">Закрыть</a></div>
            </div>
            <div id="video_object">{video}</div>
        </div>
        <div class="video_show_panel" id="video_del_info">
            [not-owner]
            <div id="addok" class="addok"><a href="/" onClick="videos.addmylist('{vid}'); return false">Добавить в Мои
                    Видеозаписи</a></div>
            [/not-owner]
            <div class="video_show_left_col">
                <div class="video_show_descr" id="video_full_descr_{vid}">{descr}</div>
                <div class="video_show_date">Добавлена {date}</div>
                <br/>
                [all-comm]<a href="/" onClick="videos.allcomment({vid}, {comm-num}, {owner-id}); return false"
                             id="all_href_lnk_comm" style="text-decoration:none">
                    <div class="photo_all_comm_bg" id="all_lnk_comm">Показать {prev-text-comm}</div>
                </a><span id="all_comments"></span>[/all-comm]
                [admin-comments]<span id="comments">{comments}</span>[/admin-comments]
            </div>
            <div class="photo_rightcol">
                {views}
                Отправитель:<br/><a href="u{user-id}" onClick="Page.Go(this.href); return false">{author}</a><br/><br/>
                <div class="menuleft" style="width:180px;">
                    [owner]<a href="/" onClick="videos.editbox({vid}); return false">
                        <div>Редактировать видеозапись</div>
                    </a>
                    <a href="/" onClick="videos.delet({vid}, 1); return false">
                        <div>Удалить видеозапись</div>
                    </a>[/owner]
                    <a onClick="Report.Box('video', '{vid}')">
                        <div>Пожаловаться на видеозапись</div>
                    </a>
                </div>
            </div>
            <div class="clear"></div>
            [admin-comments]
            <div class="video_addformcc">
                <textarea id="comment" class="inpst" style="width:717px;height:50px;margin-bottom:10px;"
                          placeholder="Комментировать.."></textarea>
                <div class="button_div fl_l">
                    <button onClick="videos.addcomment({vid}); return false" id="add_comm">Отправить</button>
                </div>
                <div class="clear"></div>
            </div>
            [/admin-comments]
        </div>
    </div>
    <div class="clear" style="height:20px"></div>
</div>
