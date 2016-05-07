<div ng-controller="CreateCtrl">
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                채널 추가
            </h1>
        </section>
        <section class="content" >
            <div class="row">
                <div class="col-md-12 jamong-pannel">
                    <div class="box box-danger">
                        <div class="box-header with-border">
                            <h3 class="box-title">채널 정보</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label>채널명</label>
                                <input
                                    id="jamong-channel-title"
                                    name="title" type="text"
                                    class="form-control" />
                            </div>
                            <div class="form-group">
                                <label>채널설명</label>
                                <textarea
                                    id="jamong-channel-content"
                                    name="content" class="form-control"></textarea>
                            </div>
                            <div class="form-group pull-right">
                                <a class="btn btn-default" ng-click="submit()">채널 추가</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
</div>
