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
                                <td data-title="'팔로우'" sortable="'follow'" filter="{follow: 'text'}">{{item.follow}}명</td>
                                <td data-title="'콘텐츠'" sortable="'contents'" filter="{contents: 'text'}">{{item.contents}}개</td>
                                <td data-title="'생성일'" sortable="'created'" filter="{created: 'text'}">{{item.datetime}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>