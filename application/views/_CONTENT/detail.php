<div ng-controller="DetailCtrl">
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                영상 상세정보
            </h1>
        </section>

        <section class="content" >
            <div class="row">
                <div class="col-md-6 jamong-pannel">
                    <div class="box box-danger">
                        <div class="box-header with-border">
                            <h3 class="box-title">영상 정보</h3>
                        </div>
                        <div class="box-body">
                            <input id="jamong-content-id" type="hidden" value="<?php echo $content->inum?>" >
                            <div class="form-group">
                                <label>업로드:</label>
                                <small>
                                    <?php echo $content->datetime; ?>
                                </small>
                            </div>
                            <div class="form-group">
                                <label>조회수:</label>
                                <small>
                                    <?php echo $content->view; ?>
                                </small>
                            </div>
                            <div class="form-group">
                                <label>좋아요:</label>
                                <small>
                                    <?php echo $content->likes; ?>
                                </small>
                            </div>
                            <div class="form-group">
                                <label>가격:</label>
                                <input id="jamong-content-price" type="text" class="form-control" value="<?php echo $content->price ?>" />
                            </div>
                            <div class="form-group">
                                <label>닉네임:</label>
                                <input id="jamong-content-nickname" type="text" class="form-control" value="<?php echo $content->nickName ?>" />
                            </div>
                            <div class="form-group">
                                <label>설명:</label>
                                <textarea id="jamong-content-content" class="form-control">
                                    <?php echo $content->talk ?>
                                </textarea>
                            </div>
                            <div class="form-group">
                                <label>채널:</label>
                                <select id="jamong-content-channel" class="form-control select2">
                                    <option value="0" selected="selected">Alabama</option>
                                    <option value="1">Alaska</option>
                                    <option value="2">California</option>
                                    <option value="3">Delaware</option>
                                    <option>Tennessee</option>
                                    <option>Texas</option>
                                    <option>Washington</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>타입:</label>
                                <select id="jamong-content-type" class="form-control select2">
                                    <option selected="selected">Alabama</option>
                                    <option>Alaska</option>
                                    <option>California</option>
                                    <option>Delaware</option>
                                    <option>Tennessee</option>
                                    <option>Texas</option>
                                    <option>Washington</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>카테고리:</label>
                                <select id="jamong-content-category" class="form-control select2">
                                    <option selected="selected">Alabama</option>
                                    <option>Alaska</option>
                                    <option>California</option>
                                    <option>Delaware</option>
                                    <option>Tennessee</option>
                                    <option>Texas</option>
                                    <option>Washington</option>
                                </select>
                            </div>
                            <div class="form-group pull-right">
                                <a class="btn btn-default"
                                   href=""
                                   ng-click="changeContentInfo()"
                                   style="margin-left: 3px; margin-bottom: 3px;">
                                    정보 변경
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 jamong-pannel">
                    <div class="box box-info content-info-right">
                        <div class="box-header with-border">
                            <h3 class="box-title">영상 썸네일</h3>
                        </div>
                        <form class="box-body" action="<?= site_url('api/content/upload_content_image?contentId=' . $content->inum) ?>"
                              method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>적용중인 사진</label>
                                <img style="display: block" class=""
                                     src="<?php
                                            if(strlen($content->picture) > 0){
                                                echo $content->picture;
                                            } else {
                                                echo '/MGMT/static/img/profile_default.png';
                                            }
                                          ?>
                                   "/>
                            </div>
                            <div class="form-group">
                                <label>영상 썸네일 사진</label>
                                <input type="file" accept="image/*" name="jamong-content-image" class="form-control my-colorpicker1" />
                            </div>
                            <div class="form-group pull-right">
                                <input type="submit" value="사진 변경" class="btn btn-success" style="margin-left: 3px; margin-bottom: 3px;">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
