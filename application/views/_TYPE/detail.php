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
                            <h3 class="box-title">채널 정보</h3>
                        </div>
                        <div class="box-body">
                            <input type="hidden" id="jamong-category-id" value="<?php echo $category->catenum?>">
                            <div class="form-group">
                                <label>카테고리 이름(한글):</label>
                                <input id="jamong-category-name-kr" type="text" class="form-control" value="<?php echo $category->name_kr?>" />
                            </div>
                            <div class="form-group">
                                <label>카테고리 이름(영어):</label>
                                <input id="jamong-category-name-en" type="text" class="form-control" value="<?php echo $category->name_en?>" />
                            </div>
                            <div class="form-group pull-right">
                                <a class="btn btn-default"
                                   href=""
                                   ng-click="changeCategoryInfo()"
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
