<?php header('Content-Type: text/html; charset=UTF-8'); ?>
<div class="content-wrapper" ng-controller="UserCtrl">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            회원
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body table-responsive table-container">
                        <table ng-table="tableParams" class="table table-bordered table-hover">
                            <tr ng-repeat="item in $data">
                                <td data-title="'아이디'" sortable="'id'" filter="{id: 'text'}">{{item.inum}}</td>
                                <td data-title="'채널명'" sortable="'title'" filter="{title: 'text'}">
                                    <a href="<?=site_url('content/detail?contentId={{item.inum}}')?>">{{item.title}}</a>
                                </td>
                                <td data-title="'닉네임'" sortable="'nickname'" filter="{nickname: 'text'}">
                                    <a href="<?=site_url('content/detail?contentId={{item.inum}}')?>">{{item.nickName}}</a>
                                </td>
                                <td data-title="'설명'" sortable="'content'" filter="{content: 'text'}">{{item.talk}}</td>
                                <td data-title="'가격'" sortable="'price'" filter="{price: 'text'}">{{item.price}}</td>
                                <td data-title="'조회수'" sortable="'view'" filter="{view: 'text'}">{{item.view}}</span></td>
                                <td data-title="'좋아요'" sortable="'like'" filter="{like: 'text'}">{{item.likes}}</span></td>
                                <td data-title="'타입'" sortable="'type'" filter="{type: 'text'}">{{item.type}}</span></td>
                                <td data-title="'카테고리'" sortable="'category'" filter="{category: 'text'}">{{item.category}}</span></td>
                                <td data-title="'업로드'" sortable="'datetime'" filter="{datetime: 'text'}">{{item.datetime}}</span></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>