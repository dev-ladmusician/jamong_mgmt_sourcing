<div ng-controller="DetailCtrl">
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                VR매니아
                <small>팔로우: 13,</small>
                <small>콘텐츠: 23</small>
            </h1>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-md-6 channel-info-left">
                    <div class="box box-danger">
                        <div class="box-header with-border">
                            <h3 class="box-title">채널 정보</h3>
                        </div>
                        <div class="box-body">
                            <input type="hidden" id="jamong-channel-id" value="<?php echo $channel->channelnum?>">
                            <div class="form-group">
                                <label>생성일:</label>
                                <small>2015-03-15</small>
                            </div>
                            <div class="form-group">
                                <label>채널 이름:</label>
                                <input id="jamong-channel-name" type="text" class="form-control" value="<?php echo $channel->channelname ?>" />
                            </div>
                            <div class="form-group">
                                <label>채널 닉네임:</label>
                                <input id="jamong-channel-nickname" type="text" class="form-control" value="<?php echo $channel->nickName ?>" />
                            </div>
                            <div class="form-group">
                                <label>채널 내용:</label>
                                <textarea id="jamong-channel-desc" class="form-control">
                                    <?php echo $channel->chdesc ?>
                                </textarea>
                            </div>
                            <div class="form-group pull-right">
                                <a class="btn btn-default"
                                   href=""
                                   ng-click="changeChannelInfo()"
                                   style="margin-left: 3px; margin-bottom: 3px;">
                                    정보 변경
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">배경 사진</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label>채널 사진</label>
                                <input type="file" class="form-control my-colorpicker1" />
                            </div>
                            <div class="form-group">
                                <label>미리 보기</label>
                                <img class="" src="http://14.49.36.93/jdisk/jamong/ch_rep/2016040113526.jpg">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box box-info channel-info-right">
                        <div class="box-header with-border">
                            <h3 class="box-title">채널 사진</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label>채널 사진</label>
                                <input type="file" class="form-control my-colorpicker1" />
                            </div>
                            <div class="form-group">
                                <label>미리 보기</label>
                                <img class="" src="http://14.49.36.93/jdisk/jamong/ch_rep/2016042617416.jpg">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
