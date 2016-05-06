<div ng-controller="DetailCtrl">
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                STEP 1. 영상 정보 입력
            </h1>
        </section>

        <section class="content" >
            <div class="row">
                <div class="col-md-12 jamong-pannel">
                    <div class="box box-danger">
                        <div class="box-header with-border">
                            <h3 class="box-title">영상 정보</h3>
                        </div>
                        <form class="box-body" method="post" action="<?= site_url('/api/content/create_info')?>">
                            <div class="form-group">
                                <label>가격:</label>
                                <input id="jamong-content-price" type="number" class="form-control" name="jamong-content-price" value="0" />
                            </div>
                            <div class="form-group">
                                <label>제목:</label>
                                <textarea id="jamong-content-title" class="form-control" name="jamong-content-title"></textarea>
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
                                        <option value="<?php echo $each->type; ?>"><?php echo $each->name_kr; ?></option>
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
                                        <option value="<?php echo $each->catenum; ?>"><?php echo $each->name_kr .'('. $each->name_en .')'; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group pull-right">
                                <input class="btn btn-default" type="submit" style="margin-left: 3px; margin-bottom: 3px;" value="다음 단계>">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
