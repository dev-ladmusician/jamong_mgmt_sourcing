<div ng-controller="DetailCtrl">
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                타입 상세정보
            </h1>
        </section>

        <section class="content" >
            <div class="row">
                <div class="col-md-4 jamong-pannel">
                    <div class="box box-danger">
                        <div class="box-header with-border">
                            <h3 class="box-title">타입 정보</h3>
                        </div>
                        <div class="box-body">
                            <input type="hidden" id="jamong-type-table-id" value="<?php echo $type->ai?>">
                            <div class="form-group">
                                <label>타입 아이디:</label>
                                <input id="jamong-type-id" type="text" class="form-control" value="<?php echo $type->type?>" />
                            </div>
                            <div class="form-group">
                                <label>타입 이름(한글):</label>
                                <input id="jamong-type-name-kr" type="text" class="form-control" value="<?php echo $type->name_kr?>" />
                            </div>
                            <div class="form-group pull-right">
                                <a class="btn btn-default"
                                   href=""
                                   ng-click="changeTypeInfo()"
                                   style="margin-left: 3px; margin-bottom: 3px;">
                                    정보 변경
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

    </div>
</div>
