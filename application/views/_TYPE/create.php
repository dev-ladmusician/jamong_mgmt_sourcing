<div ng-controller="CreateCtrl">
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
                        <form class="box-body" method="post" action="<?=site_url('/api/type/create')?>">
                            <div class="form-group">
                                <label>타입 아이디:</label>
                                <input name="type_id" type="number" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label>타입 이름(한글):</label>
                                <input name="name_kr" type="text" class="form-control"" />
                            </div>
                            <div class="form-group pull-right">
                                <input class="btn btn-default" type="submit" style="margin-left: 3px; margin-bottom: 3px;" value="타입 추가">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

    </div>
</div>
