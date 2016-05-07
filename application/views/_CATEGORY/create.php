<div ng-controller="CreateCtrl">
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                카테고리 추가
            </h1>
        </section>

        <section class="content" >
            <div class="row">
                <div class="col-md-4 jamong-pannel">
                    <div class="box box-danger">
                        <div class="box-header with-border">
                            <h3 class="box-title">카테고리 정보</h3>
                        </div>
                        <form class="box-body" action="<?=site_url('/api/category/create')?>" method="post">
                            <div class="form-group">
                                <label>카테고리 이름(한글):</label>
                                <input name="name_kr" type="text" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label>카테고리 이름(영어):</label>
                                <input name="name_en" type="text" class="form-control" />
                            </div>
                            <div class="form-group pull-right">
                                <input class="btn btn-default" type="submit" value="카테고리 추가"
                                   style="margin-left: 3px; margin-bottom: 3px;">
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </section>

    </div>
</div>
