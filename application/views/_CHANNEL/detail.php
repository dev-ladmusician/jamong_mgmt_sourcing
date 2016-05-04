<div ng-controller="DetailCtrl">
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                채널 상세정보
            </h1>
        </section>

        <section class="content" >
            <div class="row">
                <div class="col-md-4 jamong-pannel">
                    <div class="box box-danger">
                        <div class="box-header with-border">
                            <h3 class="box-title">채널 정보</h3>
                        </div>
                        <div class="box-body">
                            <input type="hidden" id="jamong-channel-id" value="<?php echo $channel->channelnum?>">
                            <div class="form-group">
                                <label>생성일:</label>
                                <small>
                                    <?php echo $channel->datetime; ?>
                                </small>
                            </div>
                            <div class="form-group">
                                <label>컨텐츠 수:</label>
                                <small>
                                    <?php echo $channel->contents; ?>
                                </small>
                            </div>
                            <div class="form-group">
                                <label>구독자 수:</label>
                                <small>
                                    <?php echo $channel->follow; ?>
                                </small>
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
                </div>
                <div class="col-md-4 jamong-pannel">
                    <div class="box box-info channel-info-right">
                        <div class="box-header with-border">
                            <h3 class="box-title">채널 사진</h3>
                        </div>
                        <form class="box-body" action="<?= site_url('api/channel/upload_channel_picture?channelId=' . $channel->channelnum) ?>"
                              method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>적용중인 사진</label>
                                <img class="" src="<?php if(isset($profile->ch_picture)){
                                    echo $profile->ch_picture; }else{ echo 'http://14.49.36.93/jdisk/jamong/ch_rep/2016042617416.jpg';}?>
                                   "/>
                            </div>
                            <div class="form-group">
                                <label>채널 사진</label>
                                <input type="file" accept="image/*" name="jamong-channel-image" class="form-control my-colorpicker1" />
                            </div>
                            <div class="form-group pull-right">
                                <input type="submit" value="정보 변경" class="btn btn-default" style="margin-left: 3px; margin-bottom: 3px;">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-4 jamong-pannel">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">배경 사진</h3>
                        </div>
                        <form class="box-body" action="<?= site_url('api/channel/upload_channel_background?channelId=' . $channel->channelnum) ?>"
                              method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>적용중인 사진</label>
                                <img class="" src="<?php if(isset($profile->bg_picture)){
                                    echo $profile->bg_picture; }else{ echo 'http://14.49.36.93/jdisk/jamong/ch_rep/2016040113526.jpg';}?>
                                   "/>
                            </div>
                            <div class="form-group">
                                <label>배경 사진</label>
                                <input type="file" accept="image/*" name="jamong-channel-background" class="form-control my-colorpicker1" />
                            </div>
                            <div class="form-group pull-right">
                                <input type="submit" value="정보 변경" class="btn btn-default" style="margin-left: 3px; margin-bottom: 3px;">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <section class="content-header">
            <h1>
                채널 매니저 관리
            </h1>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-xs-6 jamong-pannel">
                    <div class="box">
                        <div class="box-body table-responsive table-container">
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <td>아이디</td>
                                    <td>이메일</td>
                                    <td>닉네임</td>
                                    <td>관리자</td>
                                </tr>
                                <?php
                                foreach ($managers as $each) {
                                ?>
                                    <tr>
                                        <td><?php echo $each->userNumber; ?></td>
                                        <td><?php echo $each->email; ?></td>
                                        <td><?php echo $each->nickName; ?></td>
                                        <td>
                                            <a style="color: red"
                                               href="<?=site_url('api/channel/delete_manager?channelId='.$channel->channelnum.'&userId='.$each->userNumber)?>">삭제</a>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>

                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 jamong-pannel">
                    <div class="box">
                        <div class="box-body table-responsive table-container">
                            <table ng-table="tableParams" class="table table-bordered table-hover">
                                <tr ng-repeat="item in $data">
                                    <td data-title="'아이디'" sortable="'userNumber'" filter="{userNumber: 'text'}">{{item.userNumber}}</td>
                                    <td data-title="'이메일'" sortable="'email'" filter="{email: 'text'}">
                                        <a href="<?=site_url('user/detail?userId={{item.userNumber}}')?>">{{item.email}}</a>
                                    </td>
                                    <td data-title="'닉네임'" sortable="'nickname'" filter="{nickname: 'text'}">
                                        <a href="<?=site_url('user/detail?userId={{item.userNumber}}')?>">{{item.nickname}}</a>
                                    </td>
                                    <td data-title="'성인인증'" sortable="'adult'" filter="{adult: 'text'}">
                                        <span ng-if="item.adult == 'ACTIVE'" style="color: red">인증</span>
                                        <span ng-if="item.adult != 'ACTIVE'">미인증</span>
                                    </td>
                                    <td data-title="'상태'" sortable="'state'" filter="{state: 'text'}">
                                        <span ng-if="item.state == 'active'">정상</span>
                                        <span ng-if="item.state == 'out'">탈퇴</span>
                                        <span ng-if="item.state == 'block'">차단</span>
                                    </td>
                                    <td data-title="'관리자'" sortable="'manager'" filter="{manager: 'text'}">
                                        <a href="<?=site_url('api/channel/delete_manager?channelId='.$channel->channelnum.'&userId=')?>{{item.userNumber}}"
                                            style="color: red" ng-if="item.channelnum == <?php echo $channel->channelnum?>">삭제</a>
                                        <a href="<?=site_url('api/channel/add_manager?channelId='.$channel->channelnum.'&userId=')?>{{item.userNumber}}"
                                            style="color: #0D65F1" ng-if="item.channelnum != <?php echo $channel->channelnum?>">관리자부여</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
        </section>
    </div>
</div>
