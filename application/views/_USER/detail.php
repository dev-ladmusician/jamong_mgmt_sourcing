<input id="jamong-userId" type="hidden" value="<?php echo $this->session->userdata('userid') ?>" >
<input id="jamong-user-id" type="hidden" value="<?php echo $item->userNumber; ?>" >
<div ng-controller="DetailCtrl">
    <div class="content-wrapper">
        <section class="content-header">
            <h1>사용자</h1>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-4 jamong-pannel">
                    <div class="box box-info">
                        <form class="form-horizontal" action="<?= site_url('/api/user/change_password/') ?>"
                              method="post" enctype="multipart/form-data">
                            <input type="hidden" name="userId" value="<?php if ($item != null) echo $item->userNumber ?>">

                            <div class="box-header with-border">
                                <h3 class="box-title">기본정보</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="title" class="col-sm-3 control-label">id</label>
            
                                    <div class="col-sm-9 sg-item-content">
                                        <?php echo $item->userNumber ?>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label for="title" class="col-sm-3 control-label">닉네임</label>

                                    <div class="col-sm-9 sg-item-content">
                                        <?php echo $item->nickName ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="title" class="col-sm-3 control-label">이메일</label>

                                    <div class="col-sm-9 sg-item-content">
                                        <?php echo $item->email ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="title" class="col-sm-3 control-label">가입유형</label>

                                    <div class="col-sm-9 sg-item-content">
                                        <?php echo $item->accounttype ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="title" class="col-sm-3 control-label">코인</label>

                                    <div class="col-sm-9 sg-item-content">
                                        <?php echo $item->vrcoin ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="title" class="col-sm-3 control-label">결제횟수</label>

                                    <div class="col-sm-9 sg-item-content">
                                        <?php echo $item->Purchase_Cnt ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="title" class="col-sm-3 control-label">비밀번호</label>

                                    <div class="col-sm-9 sg-item-content">
                                        <input type="password" class="jamong-password-input form-control my-colorpicker1"
                                               name="password" ng-model="user.password"/>
                                        <input type="submit" value="비밀번호 변경"
                                               class="btn btn-success jamong-password-change-submit"
                                               style="margin-left: 3px; margin-bottom: 3px;"/>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-4 jamong-pannel">
                    <div class="box box-danger">
                        <div class="form-horizontal">
                            <div class="box-header with-border">
                                <h3 class="box-title">인증정보</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="title" class="col-sm-3 control-label">계정상태</label>
                                    <div class="col-sm-9 sg-item-content">
                                        <?php if ($item->state == "active") { ?>
                                            정상
                                        <?php } else if ($item->state == "out") { ?>
                                            탈퇴
                                        <?php } else if ($item->state == 'block') { ?>
                                            이용정지
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="title" class="col-sm-3 control-label">승인일자</label>
                                    <div class="col-sm-9 sg-item-content">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="title" class="col-sm-3 control-label">성인인증</label>
                                    <div class="col-sm-9 sg-item-content">
                                        <?php if ($item->adult == "ACTIVE") { ?>
                                            <span style="color: red">인증</span>
                                        <?php } else { ?>
                                            <span>미인증</span>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="title" class="col-sm-3 control-label">정지/탈퇴일자</label>
                                    <div class="col-sm-4 sg-item-content">
                                        <?php if ($item->blockdate != 0) echo $item->blockdate ?>
                                    </div>
                                    <?php if ($item->state == "active") { ?>
                                        <a class="btn btn-danger"
                                           href="<?= site_url('api/user/block_user?userId=' . $item->userNumber . '&state=' . $item->state) ?>"
                                           style="margin-left: 10px; margin-bottom: 3px; width: 105px;">
                                            계정 정지 설정
                                        </a>
                                    <?php } else { ?>
                                        <a class="btn btn-success"
                                           href="<?= site_url('api/user/block_user?userId=' . $item->userNumber . '&state=' . $item->state) ?>"
                                           style="margin-left: 10px; margin-bottom: 3px; width: 105px;">
                                            계정 정지 풀기
                                        </a>
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label for="title" class="col-sm-3 control-label">채널관리자</label>
                                    <div class="col-sm-4 sg-item-content">
                                        <?php if ($item->is_admin) { ?>
                                            <span style="color: red">채널 관리자</span>
                                        <?php } else { ?>
                                            <span>일반회원</span>
                                        <?php } ?>
                                    </div>
                                    <?php if ($item->is_admin) { ?>
                                        <a class="btn btn-default"
                                           href="<?= site_url('api/user/change_isadmin?userId=' . $item->userNumber . '&isadmin=false') ?>"
                                           style="margin-left: 10px; margin-bottom: 3px; width: 105px;">
                                            채널관리 박탈
                                        </a>
                                    <?php } else { ?>

                                        <a class="btn btn-success jamong-add-manager"
                                           href="#"
                                           data-toggle="modal" data-target="#myModal"
                                           style="margin-left: 10px; margin-bottom: 3px; width: 105px;">
                                            채널관리 부여
                                        </a>
                                    <?php } ?>
                                </div>
                                <?php if($this->session->userdata('issuperadmin')) { ?>
                                    <div class="form-group">
                                        <label for="title" class="col-sm-3 control-label">전체 관리자</label>

                                        <div class="col-sm-4 sg-item-content">
                                            <?php if ($item->is_superadmin) { ?>
                                                <span style="color: red">관리자</span>
                                            <?php } else { ?>
                                                <span>관리자x</span>
                                            <?php } ?>
                                        </div>
                                        <?php if ($item->is_superadmin) { ?>
                                            <a class="btn btn-default"
                                               href="<?= site_url('api/user/change_is_superadmin?userId=' . $item->userNumber . '&isadmin=false') ?>"
                                               style="margin-left: 10px; margin-bottom: 3px; width: 105px;">
                                                관리자박탈
                                            </a>
                                        <?php } else { ?>
                                            <a class="btn btn-success"
                                               href="<?= site_url('api/user/change_is_superadmin?userId=' . $item->userNumber . '&isadmin=true') ?>"
                                               style="margin-left: 10px; margin-bottom: 3px; width: 105px;">
                                                관리자부여
                                            </a>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 jamong-pannel">
                    <div class="box box-success">
                        <div class="form-horizontal">
                            <div class="box-header with-border">
                                <h3 class="box-title">프로필</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="title" class="col-sm-3 control-label">사진</label>

                                    <div class="col-sm-9 sg-item-content">
                                        <?php if ($item->picture == "") { ?>
                                            <img class="jamong_profile"
                                                 src="<?= site_url('static/img/profile_default.png') ?>">
                                        <?php } else { ?>
                                            <img class="jamong_profile"
                                                 src="<?=$item->picture?>">
                                        <?php } ?>
                                    </div>
                                </div>
                                <form class="form-group" action="<?= site_url('api/user/upload_profile_image?userId=' . $item->userNumber) ?>"
                                      method="post" enctype="multipart/form-data">
                                    <label for="title" class="col-sm-3 control-label">이미지 변경</label>

                                    <div class="col-sm-9 sg-item-content">
                                        <input type="file" class="jamong-password-input form-control my-colorpicker1"
                                               value="" name="jamong-profile-image" accept="image/*"/>
                                        <input type="submit" class="btn btn-success"
                                               value="프로필 변경" style="margin-left: 3px; margin-bottom: 3px;"/>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="content-header">
            <h1>
                채널관리
            </h1>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body table-responsive table-container">
                            <table ng-table="tableParams" class="table table-bordered table-hover">
                                <tr ng-repeat="item in $data">
                                    <td data-title="'아이디'" sortable="'channelnum'" filter="{channelnum: 'text'}">{{item.channelnum}}</td>
                                    <td data-title="'채널이름'" sortable="'channelname'" filter="{channelname: 'text'}">
                                        <a href="<?=site_url('channel/detail?channelId={{item.channelnum}}')?>">{{item.channelname}}</a>
                                    </td>
                                    <td data-title="'닉네임'" sortable="'nickname'" filter="{nickname: 'text'}">
                                        <a href="<?=site_url('channel/detail?channelId={{item.channelnum}}')?>">{{item.nickName}}</a>
                                    </td>
                                    <td data-title="'구독자'" sortable="'follow'" filter="{follow: 'text'}">{{item.follow}}명</td>
                                    <td data-title="'콘텐츠'" sortable="'contents'" filter="{contents: 'text'}">{{item.contents}}개</td>
                                    <td data-title="'생성일'" sortable="'created'" filter="{created: 'text'}">{{item.datetime}}</td>
                                    <td data-title="'관리'">
                                        <a ng-if="item.isdeprecated == 0" style="color: red"
                                           href="<?=site_url('api/channel/change_isdeprecated?channelId={{item.channelnum}}&isdeprecated=true')?>">폐쇄</a>
                                        <a ng-if="item.isdeprecated == 1" href="<?=site_url('api/channel/change_isdeprecated?channelId={{item.channelnum}}&isdeprecated=false')?>">복구</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="content-header">
            <h1>결제정보</h1>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="form-horizontal">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="summary" class="col-sm-1 control-label">결제횟수</label>

                                    <div class="col-sm-5 sg-item-content">
                                        <?php echo $item->paycount ?>
                                    </div>
                                    <label for="summary" class="col-sm-1 control-label">마지막 결제일</label>

                                    <div class="col-sm-5 sg-item-content">
                                        <?php echo $item->lastpayday ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="summary" class="col-sm-1 control-label">VR코인</label>

                                    <div class="col-sm-5 sg-item-content">
                                        <?php echo $item->vrcoin ?>
                                    </div>
                                    <label for="summary" class="col-sm-1 control-label">키스토어</label>

                                    <div class="col-sm-5 sg-item-content">
                                        <?php echo $item->keystore ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <a class="btn btn-primary pull-right" style="margin-right: 5px;"
                               href="<?= site_url('user/index') ?>">
                                목록보기
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">채널관리자 부여</h4>
                </div>
                <div class="modal-body">
                    <section class="content">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box">
                                    <div class="box-body table-responsive table-container">
                                        <table ng-table="channelTableParams" class="table table-bordered table-hover">
                                            <tr ng-repeat="item in $data">
                                                <td data-title="'선텍'">
                                                    <input type="checkbox" value="{{item.checked}}" ng-click="item.checked = !item.checked">
                                                </td>
                                                <td data-title="'아이디'" sortable="'channelnum'" filter="{channelnum: 'text'}">{{item.channelnum}}</td>
                                                <td data-title="'채널이름'" sortable="'channelname'" filter="{channelname: 'text'}">
                                                    <a href="<?=site_url('channel/detail?channelId={{item.channelnum}}')?>">{{item.channelname}}</a>
                                                </td>
                                                <td data-title="'닉네임'" sortable="'nickname'" filter="{nickname: 'text'}">
                                                    <a href="<?=site_url('channel/detail?channelId={{item.channelnum}}')?>">{{item.nickName}}</a>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">닫기</button>
                    <button type="button" class="btn btn-primary" ng-click="submitManager()">권한부여</button>
                </div>
            </div>
        </div>
    </div>
</div>
