<div class="content-wrapper" ng-controller="TypeCtrl">
    <section class="content-header">
        <h1>
            타입 관리
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body table-responsive table-container">
                        <table ng-table="tableParams" class="table table-bordered table-hover">
                            <tr ng-repeat="item in $data">
                                <td data-title="'테이블아이디'" sortable="'ai'" filter="{ai: 'text'}">{{item.ai}}</td>
                                <td data-title="'타입아이디'" sortable="'type'" filter="{type: 'text'}">
                                    <a href="<?=site_url('type/detail?tableId={{item.ai}}')?>">{{item.type}}</a>
                                </td>
                                <td data-title="'타입이름'" sortable="'name_kr'" filter="{name_kr: 'text'}">
                                    <a href="<?=site_url('type/detail?tableId={{item.ai}}')?>">{{item.name_kr}}</a>
                                </td>
                                <td data-title="'관리'">
                                    <a ng-if="item.isdeprecated == 0" style="color: red"
                                       href="<?=site_url('api/type/change_isdeprecated?tableId={{item.ai}}&isdeprecated=true')?>">삭제</a>
                                    <a ng-if="item.isdeprecated == 1" href="<?=site_url('api/type/change_isdeprecated?tableId={{item.ai}}&isdeprecated=false')?>">복구</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <a class="btn btn-success pull-right" href="<?= site_url('type/create')?>">타입 추가</a>
    </section>

</div>