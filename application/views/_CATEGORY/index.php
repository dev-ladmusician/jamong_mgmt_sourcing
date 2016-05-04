<div class="content-wrapper" ng-controller="CategoryCtrl">
    <section class="content-header">
        <h1>
            카테고리 관리
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body table-responsive table-container">
                        <table ng-table="tableParams" class="table table-bordered table-hover">
                            <tr ng-repeat="item in $data">
                                <td data-title="'아이디'" sortable="'catenum'" filter="{catenum: 'text'}">{{item.catenum}}</td>
                                <td data-title="'카테고리이름'" sortable="'name_kr'" filter="{name_kr: 'text'}">
                                    <a href="<?=site_url('category/detail?categoryId={{item.catenum}}')?>">{{item.name_kr}}</a>
                                </td>
                                <td data-title="'카테고리이름'" sortable="'name_en'" filter="{name_en: 'text'}">
                                    <a href="<?=site_url('category/detail?categoryId={{item.catenum}}')?>">{{item.name_en}}</a>
                                </td>
                                <td data-title="'관리'">
                                    <a ng-if="item.isDeprecated == 0" style="color: red"
                                       href="<?=site_url('api/category/change_isdeprecated?categoryId={{item.catenum}}&isdeprecated=true')?>">삭제</a>
                                    <a ng-if="item.isDeprecated == 1" href="<?=site_url('api/category/change_isdeprecated?categoryId={{item.catenum}}&isdeprecated=false')?>">복구</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <a class="btn btn-success pull-right" href="<?= site_url('category/create')?>">카테고리 추가</a>
    </section>

</div>