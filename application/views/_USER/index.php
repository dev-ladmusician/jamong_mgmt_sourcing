<?php header('Content-Type: text/html; charset=UTF-8'); ?>
<div class="content-wrapper" ng-controller="UserCtrl">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            회원
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
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
                                <td data-title="'결제횟수'" sortable="'purchaseNum'" filter="{purchaseNum: 'text'}">{{item.purchaseNum}}</td>
                                <td data-title="'코인'" sortable="'vrcoin'" filter="{vrcoin: 'text'}">{{item.vrcoin}}</td>
                                <td data-title="'가입경로'" sortable="'accounttype'" filter="{accounttype: 'text'}">
                                    <span ng-if="item.accounttype != 'NULL'">{{item.accounttype}}</span>
                                </td>
                                <td data-title="'성인인증'" sortable="'adult'" filter="{adult: 'text'}">
                                    <span ng-if="item.adult == 'ACTIVE'" style="color: red">인증</span>
                                    <span ng-if="item.adult != 'ACTIVE'">미인증</span>
                                </td>
                                <td data-title="'상태'" sortable="'state'" filter="{state: 'text'}">
                                    <span ng-if="item.state == 'active'">정상</span>
                                    <span ng-if="item.state == 'out'">탈퇴</span>
                                </td>
                                <td data-title="'정지/탈퇴일자'" sortable="'statedate'" filter="{statedate: 'text'}">{{item.statedate}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>