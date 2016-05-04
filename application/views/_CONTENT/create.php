<div ng-controller="DetailCtrl">
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                영상 상세정보
            </h1>
        </section>

        <section class="content" >
            <div class="row">
                <div class="col-md-6 jamong-pannel">
                    <div class="box box-danger">
                        <div class="box-header with-border">
                            <h3 class="box-title">영상 정보</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label>가격:</label>
                                <input id="jamong-content-price" type="text" class="form-control" value="" />
                            </div>
                            <div class="form-group">
                                <label>닉네임:</label>
                                <input id="jamong-content-nickname" type="text" class="form-control" value="" />
                            </div>
                            <div class="form-group">
                                <label>설명:</label>
                                <textarea id="jamong-content-content" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label>채널:</label>
                                <select id="jamong-content-channel" class="form-control select2">
                                    <option value="0" selected="selected">Alabama</option>
                                    <option value="1">Alaska</option>
                                    <option value="2">California</option>
                                    <option value="3">Delaware</option>
                                    <option>Tennessee</option>
                                    <option>Texas</option>
                                    <option>Washington</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>타입:</label>
                                <select id="jamong-content-type" class="form-control select2">
                                    <option selected="selected">Alabama</option>
                                    <option>Alaska</option>
                                    <option>California</option>
                                    <option>Delaware</option>
                                    <option>Tennessee</option>
                                    <option>Texas</option>
                                    <option>Washington</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>카테고리:</label>
                                <select id="jamong-content-category" class="form-control select2">
                                    <option selected="selected">Alabama</option>
                                    <option>Alaska</option>
                                    <option>California</option>
                                    <option>Delaware</option>
                                    <option>Tennessee</option>
                                    <option>Texas</option>
                                    <option>Washington</option>
                                </select>
                            </div>
                            <div class="form-group pull-right">
                                <a class="btn btn-default"
                                   href=""
                                   ng-click="changeContentInfo()"
                                   style="margin-left: 3px; margin-bottom: 3px;">
                                    정보 변경
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 jamong-pannel">
                    <div class="box box-info content-info-right">
                        <div class="box-header with-border">
                            <h3 class="box-title">영상 썸네일</h3>
                        </div>
                        <form class="box-body" action=""
                              method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>영상 썸네일 사진</label>
                                <input type="file" accept="image/*" name="jamong-content-image" class="form-control my-colorpicker1" />
                            </div>
                            <div class="form-group pull-right">
                                <input type="submit" value="사진 변경" class="btn btn-success" style="margin-left: 3px; margin-bottom: 3px;">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
