<div class="content-wrapper" ng-controller="DetailCtrl">
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
                                <a class="btn btn-danger"
                                   href="<?= site_url('api/user/block_user?userId=' . $item->userNumber . '&state=' . $item->state) ?>"
                                   style="margin-left: 10px; margin-bottom: 3px; width: 105px;">
                                    계정 정지 설정
                                </a>
                            </div>
                            <div class="form-group">
                                <label for="title" class="col-sm-3 control-label">관리자여부</label>

                                <div class="col-sm-4 sg-item-content">
                                    <?php if ($item->isadmin) { ?>
                                        <span style="color: red">관리자</span>
                                    <?php } else { ?>
                                        <span>일반회원</span>
                                    <?php } ?>
                                </div>
                                <?php if ($item->isadmin) { ?>
                                    <a class="btn btn-default"
                                       href="<?= site_url('api/user/change_isadmin?userId=' . $item->userNumber . '&isadmin=false') ?>"
                                       style="margin-left: 10px; margin-bottom: 3px; width: 105px;">
                                        관리자박탈
                                    </a>
                                <?php } else { ?>
                                    <a class="btn btn-success"
                                       href="<?= site_url('api/user/change_isadmin?userId=' . $item->userNumber . '&isadmin=true') ?>"
                                       style="margin-left: 10px; margin-bottom: 3px; width: 105px;">
                                        관리자부여
                                    </a>
                                <?php } ?>
                            </div>
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