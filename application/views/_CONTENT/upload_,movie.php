<div ng-controller="DetailCtrl">
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                STEP 2. 영상 업로드
            </h1>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-md-6 jamong-pannel">
                    <div class="box box-danger">
                        <div class="box-header with-border">
                            <h3 class="box-title">영상 정보</h3>
                        </div>
                        <form class="box-body" method="post" action="<?= site_url('/api/content/upload_movie?contentId' . $contentId) ?>"
                              enctype="multipart/form-data">
                            <div class="form-group">
                                <label>업로드할 영상</label>
                                <input type="file" accept="video/*" name="jamong-content-video"
                                       class="form-control my-colorpicker1"/>
                            </div>
                            <div class="form-group pull-right">
                                <input type="submit" value="영상 업로드" class="btn btn-success"
                                       style="margin-left: 3px; margin-bottom: 3px;">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
