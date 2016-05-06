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
                        <form class="box-body">
                            <div class="form-group">
                                <label>가격:</label>
                                <input id="jamong-content-price" type="text" class="form-control" name="jamong-content-price" />
                            </div>
                            <div class="form-group">
                                <label>닉네임:</label>
                                <input id="jamong-content-nickname" type="text" class="form-control" name="jamong-content-nickname" />
                            </div>
                            <div class="form-group">
                                <label>설명:</label>
                                <textarea id="jamong-content-content" class="form-control" name="jamong-content-content"></textarea>
                            </div>
                            <div class="form-group">
                                <label>채널:</label>
                                <select id="jamong-content-channel" class="form-control select2" name="jamong-content-channel">
                                    <?php
                                    foreach ($channels as $each) {
                                        ?>
                                        <option value="<?php echo $each->channelnum; ?>"><?php echo $each->channelname; ?></option>
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
                                        <option value="<?php echo $each->channelnum; ?>"><?php echo $each->channelname; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>카테고리:</label>
                                <select id="jamong-content-category" class="form-control select2" name="jamong-content-category">
                                    <?php
                                    foreach ($types as $each) {
                                        ?>
                                        <option value="<?php echo $each->channelnum; ?>"><?php echo $each->channelname; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group pull-right">
                                <a class="btn btn-default"
                                   href=""
                                   ng-click="createContentInfo()"
                                   style="margin-left: 3px; margin-bottom: 3px;">
                                    정보 추가
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
<!--                <div class="col-md-6 jamong-pannel">-->
<!--                    <div class="box box-info content-info-right">-->
<!--                        <div class="box-header with-border">-->
<!--                            <h3 class="box-title">영상 업로드</h3>-->
<!--                        </div>-->
<!--                        <form class="box-body" action=""-->
<!--                              method="post" enctype="multipart/form-data">-->
<!--                            <div class="form-group">-->
<!--                                <label>업로드할 영상</label>-->
<!--                                <input type="file" accept="video/*" name="jamong-content-video" class="form-control my-colorpicker1" />-->
<!--                            </div>-->
<!--                            <div class="form-group pull-right">-->
<!--                                <input type="submit" value="영상 업로드" class="btn btn-success" style="margin-left: 3px; margin-bottom: 3px;">-->
<!--                            </div>-->
<!--                        </form>-->
<!--                    </div>-->
<!--                </div>-->
            </div>
        </section>
    </div>
</div>
