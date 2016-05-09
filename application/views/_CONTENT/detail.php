<input type="hidden" id="jamong-content-info-type" value="<?php echo $content->type; ?>">
<div ng-controller="DetailCtrl">
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                영상 상세정보
            </h1>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-6 jamong-pannel">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">영상 정보</h3>
                        </div>
                        <form class="box-body"
                              action="<?= site_url('api/content/change_content_info?contentId=' . $content->inum) ?>"
                              method="post" enctype="multipart/form-data">

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
                                <input id="jamong-content-price" type="text" class="form-control"
                                       name="jamong-content-price"
                                       value="<?php echo $content->price ?>"/>
                            </div>
                            <div class="form-group">
                                <label>제목:</label>
                                <input id="jamong-content-title" type="text" class="form-control"
                                       name="jamong-content-title"
                                       value="<?php echo $content->title ?>"/>
                            </div>
                            <div class="form-group">
                                <label>설명:</label>
                                <textarea id="jamong-content-content" class="form-control"
                                name="jamong-content-content"><?php echo $content->talk ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>채널:</label>
                                <select id="jamong-content-channel" class="form-control select2" name="jamong-content-channel">
                                    <?php
                                    foreach ($channels as $each) {
                                        ?>
                                        <option
                                            <?php
                                            if ($content->ch == $each->channelnum) {
                                                ?>
                                                selected="selected"
                                                <?php
                                            }
                                            ?>
                                            value="<?php echo $each->channelnum; ?>"><?php echo $each->channelname; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>타입:</label>
                                <select id="jamong-content-type" class="form-control select2" name="jamong-content-type">
                                    <?php
                                    foreach ($types as $each) {
                                        ?>
                                        <option
                                            <?php
                                            if ($content->type == $each->type) {
                                                ?>
                                                selected="selected"
                                                <?php
                                            }
                                            ?>
                                            value="<?php echo $each->type; ?>"><?php echo $each->name_kr; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>카테고리:</label>
                                <select id="jamong-content-category" class="form-control select2" name="jamong-content-category">
                                    <?php
                                    foreach ($categories as $each) {
                                        ?>
                                        <option
                                            <?php
                                            if ($content->cate == $each->catenum) {
                                                ?>
                                                selected="selected"
                                                <?php
                                            }
                                            ?>
                                            value="<?php echo $each->catenum; ?>"><?php echo $each->name_kr . '(' . $each->name_en . ')'; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group pull-right">
                                <input type="submit" value="정보 변경" class="btn btn-default"
                                       style="margin-left: 3px; margin-bottom: 3px;">
                            </div>
                        </form>

                    </div>
                </div>
                <div class="col-md-6 jamong-pannel">
                    <div class="box box-danger">
                        <div class="box-header with-border">
                            <h3 class="box-title">컨텐츠 업로드</h3>
                        </div>
                        <form class="box-body" method="post" enctype="multipart/form-data"
                              action="<?= site_url('/api/content/upload_movie?contentId=' . $content->inum)?>">
                            <?php if (strlen($content->filename) > 0) { ?>
                                <div class="form-group">
                                    <label>영상 업로드 상태:</label>
                                    <small style="color: red">
                                        <?php echo $content->uploadstat; ?>
                                    </small>
                                </div>
                            <?php } ?>
                            <div class="form-group">
                                <label>업로드 할 컨텐츠</label>
                                <small class="jamong-content-video-title">업로드된 영상: </small>
                                <small class="jamong-content-video-content">
                                    <?php
                                    if (strlen($content->filename) > 0) {
                                    echo $content->filename.".".$content->format;
                                    }
                                    ?>
                                </small>
                                <input type="file" name="jamong-content-movie"  class="form-control my-colorpicker1"/>
                            </div>
                            <div class="form-group pull-right">
                                <?php
                                if (strlen($content->filename) > 0) {
                                ?>
                                    <input class="btn btn-default" type="submit"  style="margin-left: 3px; margin-bottom: 3px;" value="동영상 수정">
                                <?php
                                } else {
                                ?>
                                    <input class="btn btn-default" type="submit"  style="margin-left: 3px; margin-bottom: 3px;" value="동영상 업로드">
                                <?php
                                }
                                ?>

                            </div>
                        </form>
                        <?php if (strlen($content->filename) > 0) { ?>
                            <div class="jamong-content-for-vr">
                                <div class="box-header with-border">
                                    <h3 class="box-title">컨텐츠 XML 업로드</h3>
                                </div>
                                <form class="box-body" method="post" enctype="multipart/form-data"
                                      action="<?= site_url('/api/content/create_xml?contentId=' . $content->inum)?>">
                                    <div class="form-group">
                                        <label>현재 xml 업로드:</label>
                                        <?php if (strlen($content->xml) > 0) { ?>
                                            <small style="color: red">완료</small>
                                        <?php } else { ?>
                                            <small style="color: red">업로드 되지 않음</small>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group">
                                        <label>미리보기</label>
                                        <iframe style="width: 100%;"
                                                src="https://s3-ap-northeast-1.amazonaws.com/dongshin.movie/playlist/<?php echo $content->filename.'/'.$content->filename.'.xml'?>"></iframe>
                                    </div>
                                    <div class="form-group">
                                        <label>xml 파일</label>
                                        <input type="file" name="jamong-content-xml"  class="form-control my-colorpicker1"/>
                                    </div>
                                    <div class="form-group pull-right">
                                        <?php
                                        if (strlen($content->xml) > 0) {
                                            ?>
                                            <input class="btn btn-default" type="submit"  style="margin-left: 3px; margin-bottom: 3px;" value="xml 수정">
                                            <?php
                                        } else {
                                            ?>
                                            <input class="btn btn-default" type="submit"  style="margin-left: 3px; margin-bottom: 3px;" value="xml 업로드">
                                            <?php
                                        }
                                        ?>

                                    </div>
                                </form>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-md-6 jamong-pannel">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">썸네일 업로드</h3>
                                <?php if ($content->uploadstat == "Progressing") { ?>
                                    <small class="jamong-video-not-complete">람다가 동작중입니다. 동작이 완료되면 미리보기가 가능합니다.</small>
                                <?php } ?>
                            </div>
                            <?php if (strlen($content->filename) > 0) { ?>
                                <form class="box-body" method="post" enctype="multipart/form-data"
                                      action="<?= site_url('/api/content/upload_content_image?contentId='.$content->inum.'&contentFileName='.$content->filename)?>">
                                    <div class="form-group">
                                        <label>영상 썸네일 사진</label>
                                        <input type="file" accept="image/*" name="jamong-content-image"
                                               class="form-control my-colorpicker1"/>
                                    </div>

                                    <div class="form-group">
                                        <label>적용중인 사진</label>
                                        <img style="display: block" class=""
                                             src="<?php
                                             if (strlen($content->filename) > 0) {
                                                 if (strlen($content->picture) > 0) {
                                                     echo $content->picture;
                                                 } else {
                                                     echo "https://s3-ap-northeast-1.amazonaws.com/dongshin.images/playlist/".$content->filename."/high_00001.png";
                                                 }
                                             } else {
                                                 echo '/MGMT/static/img/profile_default.png';
                                             }
                                             ?>
                                   "/>
                                    </div>
                                    <div class="form-group pull-right">
                                        <input class="btn btn-default" type="submit"  style="margin-left: 3px; margin-bottom: 3px;" value="썸네일 업로드">
                                    </div>
                                </form>
                            <?php } else { ?>
                                <div class="jamong-no-video-upload">영상을 먼저 업로드 해주세요.</div>
                            <?php } ?>
                        </div>
                </div>
            </div>
        </section>
    </div>
</div>
