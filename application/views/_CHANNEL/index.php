<div class="content-wrapper" ng-controller="ChannelCtrl">
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
                <a class="btn btn-success pull-right" href="<?= site_url('channel/create')?>">채널 추가</a>
            </div>
        </div>
    </section>
</div>