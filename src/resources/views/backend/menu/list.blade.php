@extends('layouts.appbackend')
@section('style')
<link href="{{ asset('template-end/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('template-end/libs/nestable2/jquery.nestable.min.css') }}" rel="stylesheet" type="text/css">
<style>
    .dd {
        max-width: 100%;
    }

    .dd-empty {
        display: none;
    }

    .dd3-list .dd3-handle:before {
        content: "\F35C";
        font-family: "Material Design Icons";
        color: #adb5bd;
    }
 
</style>
@endsection
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title"> <i class="fe-list"></i> จัดการเมนู </h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6" style="display: flex; align-items: center;">
                                <div class="h4 m-0"> <i class="fe-bar-chart-line"></i> เรียงลำดับเมนู </div>
                            </div>
                            <div class="col-md-6 text-right">
                                <button type="button" class="btn btn-lg btn-primary" data-toggle="modal" data-target="#exampleModal">
                                    <i class="fe-plus-square"></i> เพิ่มเมนู
                                </button>
                            </div>
                        </div>
                        <hr>
                        <div class="custom-dd-empty dd" id="nestable-main">
                            <ol class="dd-list dd3-list">

                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> <i class="fe-plus-square"></i> เพิ่มเมนู </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('save.slideshow') }}" id="form" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label class="ml-1" for="menu_name"> ชื่อเมนู </label>
                            <input id="menu_name" type="text" maxlength="100" class="form-control form-control-lg @error('menu_name') invalid @enderror" name="menu_name" value="{{ old('menu_name') }}" autocomplete="menu_name" autofocus placeholder="โปรดระบุข้อมูลไปเกิน 100 ตัวอักษร">
                            @error('menu_name')
                            <ul class="parsley-errors-list filled">
                                <li class="parsley-required">{{ $message }}</li>
                            </ul>
                            @enderror
                        </div>
                        <div class="col-md-12 form-group">
                            <label class="ml-1" for="menu_slug"> ลิงค์ </label>
                            <input id="menu_slug" type="text" class="form-control form-control-lg @error('menu_slug') invalid @enderror" name="menu_slug" value="{{ old('menu_slug') }}" autocomplete="menu_slug" autofocus placeholder="โปรดระบุข้อมูล...">
                            @error('menu_slug')
                            <ul class="parsley-errors-list filled">
                                <li class="parsley-required">{{ $message }}</li>
                            </ul>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-lg btn-secondary" data-dismiss="modal">ปิด</button>
                    <button type="button" class="btn btn-lg btn-primary waves-effect waves-light" id="addDditem">
                        <span class="text-submit"> <i class="fe-save"></i> บันทึกข้อมูล </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Update -->
<div class="modal fade" id="ModalUpdate" tabindex="-1" role="dialog" aria-labelledby="ModalUpdateLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalUpdateLabel"> <i class="fe-edit"></i> แก้ไขเมนู </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="hiddenID" name="hiddenID" value="">
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label class="ml-1" for="UPmenu_name"> ชื่อเมนู </label>
                        <input id="UPmenu_name" type="text" maxlength="100" class="form-control form-control-lg @error('UPmenu_name') invalid @enderror" name="UPmenu_name" value="{{ old('UPmenu_name') }}" autocomplete="UPmenu_name" autofocus placeholder="โปรดระบุข้อมูลไปเกิน 100 ตัวอักษร">
                    </div>
                    <div class="col-md-12 form-group">
                        <label class="ml-1" for="UPmenu_slug"> ลิงค์ </label>
                        <input id="UPmenu_slug" type="text" class="form-control form-control-lg @error('UPmenu_slug') invalid @enderror" name="UPmenu_slug" value="{{ old('UPmenu_slug') }}" autocomplete="UPmenu_slug" autofocus placeholder="โปรดระบุข้อมูล...">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-lg btn-secondary" data-dismiss="modal">ปิด</button>
                <button type="button" class="btn btn-lg btn-primary waves-effect waves-light" id="upDditem">
                    <span class="text-submit"> <i class="fe-save"></i> บันทึกข้อมูล </span>
                </button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script src="{{ asset('template-end/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('template-end/libs/nestable2/jquery.nestable.min.js') }}"></script>
<script>
    getDataMenu("Y")

    function getDataMenu(type) {
        $.post("{{ route('get.data.menu') }}", {
                '_token': "{{ csrf_token() }}",
            },
            function(data) {
                var obj = [];
                if (data != false) {
                    obj = data[0].list;
                }
                var options = {};
                options = {
                    json: obj,
                }
                if (type == "Y") {
                    options = {
                        json: obj,
                        listNodeName: 'ol',
                        itemNodeName: 'li',
                        handleNodeName: 'div',
                        contentNodeName: 'div',
                        itemClass: 'dd-item dd3-item',
                        handleClass: 'dd-handle dd3-handle',
                        contentClass: 'dd3-content',
                        maxDepth: 2,
                        listRenderer: function(children, options) {
                            var html = '<' + options.listNodeName + ' class="' + options.listClass + '">';
                            html += children;
                            html += '</' + options.listNodeName + '>';

                            return html;
                        },
                        itemRenderer: function(item_attrs, content, children, options, item) {
                            var item_attrs_string = $.map(item_attrs, function(value, key) {
                                return ' ' + key + '="' + value + '"';
                            }).join(' ');

                            var html = '<' + options.itemNodeName + item_attrs_string + '>';
                            html += '<' + options.handleNodeName + ' class="' + options.handleClass + '"></' + options.handleNodeName + '>';
                            html += '<' + options.contentNodeName + ' class="' + options.contentClass + '">';
                            html += content;
                            html += '   </' + options.contentNodeName + '>';
                            html += children;
                            html += '</' + options.itemNodeName + '>';

                            return html;
                        }
                    }
                    $('#nestable-main').nestable(options).on('change', updateOutput);
                    updateOutput($('#nestable-main').data('output', $('#nestable-main')));
                }
            }
        );
    }

    var updateOutput = function(e) {
        var list = e.length ? e : $(e.target),
            output = list.data('output');
        if (window.JSON) {
            output.val(window.JSON.stringify(list.nestable('serialize')));
            $.post("{{ route('save.menu') }}", {
                    '_token': "{{ csrf_token() }}",
                    'output': output.val()
                },
                function(data) {
                    getDataMenu("N");
                }
            );
        } else {
            output.val('JSON browser support required for this demo.');
        }
    };

    $(document).on('click', '#addDditem', function(event) {  
        var menu_name = $('input[name=menu_name]').val();
        var menu_slug = $('input[name=menu_slug]').val();
        if (menu_name == "" && menu_slug == "") {
            $('input[name=menu_name]').focus();
            return false;
        }
        var Othis = $(this);
        Othis.prop("disabled", true);
        $('.text-submit').html('<i class="mdi mdi-spin mdi-loading"></i> กรุณารอสักครู่...');
        $.post("{{ route('save.menu.items') }}", {
                '_token': "{{ csrf_token() }}",
                menu_name: $('input[name=menu_name]').val(),
                menu_slug: $('input[name=menu_slug]').val(),
            },
            function(data) {
                $('input[name=menu_name]').val(""),
                $('input[name=menu_slug]').val(""),
                getDataMenu("Y")
                Othis.prop("disabled", false);
                $('.text-submit').html('<i class="fe-save"></i> บันทึกข้อมูล');
                $('#exampleModal').modal('hide');
                var id = data.id;
                var name = data.name;
                var slug = data.slug;
                var html = ""; 
              
                html += '<li class="dd-item dd3-item" data-id="' + id + '">';
                html += '    <div class="dd-handle dd3-handle"></div>';
                html += '        <div class="dd3-content">';
                html += '           <div class="d-flex"> ';
                html += '               <div class="mr-auto contentID-' + id + '"> ID : ' + id + ' ' + name + ' [URL : ' + slug + ']</div>';
                html += '               <a href="javascript:void(0)" data-id="' + id + '" data-name="' + name + '" data-slug="' + slug + '" class="Cupdate" style="height: unset;font-size: 16px; margin: 0 5px;"><i class="mdi mdi-pencil"></i></a>';
                html += '               <a href="javascript:void(0)" data-id="' + id + '" class="Cdelete" style="height: unset;font-size: 16px; margin: 0 5px;"><i class="mdi mdi-close"></i></a>';
                html += '           </div> ';
                html += '       </div>';
                html += '</li>';
                 
                $('.dd-list:first-child').prepend(html);
                // [{"id":17,"content":"<div class=\"d-flex\"> <div class=\"mr-auto contentID-17\"> ID : 17 \u0e2b\u0e19\u0e49\u0e32\u0e2b\u0e25\u0e31\u0e01 [URL : \/]<\/div> <div>  \n                <a href=\"javascript:void(0)\" data-id=\"17\" class=\"Cupdate\" data-name=\"\u0e2b\u0e19\u0e49\u0e32\u0e2b\u0e25\u0e31\u0e01\" data-slug=\"\/\" style=\"height: unset;font-size: 16px; margin: 0 5px;\"><i class=\"mdi mdi-pencil\"><\/i><\/a>\n                <a href=\"javascript:void(0)\" data-id=\"17\" class=\"Cdelete\" style=\"height: unset;font-size: 16px; margin: 0 5px;\"><i class=\"mdi mdi-close\"><\/i><\/a>  \n                <\/div> <\/div>"},{"id":18,"content":"<div class=\"d-flex\"> <div class=\"mr-auto contentID-18\"> ID : 18 \u0e40\u0e01\u0e35\u0e48\u0e22\u0e27\u0e01\u0e31\u0e1a\u0e2a\u0e16\u0e32\u0e1a\u0e31\u0e19 [URL : #]<\/div> <div>  \n                <a href=\"javascript:void(0)\" data-id=\"18\" class=\"Cupdate\" data-name=\"\u0e40\u0e01\u0e35\u0e48\u0e22\u0e27\u0e01\u0e31\u0e1a\u0e2a\u0e16\u0e32\u0e1a\u0e31\u0e19\" data-slug=\"#\" style=\"height: unset;font-size: 16px; margin: 0 5px;\"><i class=\"mdi mdi-pencil\"><\/i><\/a>\n                <a href=\"javascript:void(0)\" data-id=\"18\" class=\"Cdelete\" style=\"height: unset;font-size: 16px; margin: 0 5px;\"><i class=\"mdi mdi-close\"><\/i><\/a>  \n                <\/div> <\/div>"},{"id":19,"content":"<div class=\"d-flex\"> <div class=\"mr-auto contentID-19\"> ID : 19 \u0e02\u0e49\u0e2d\u0e21\u0e39\u0e25\u0e02\u0e48\u0e32\u0e27\u0e2a\u0e32\u0e23\u0e2a\u0e39\u0e48\u0e0a\u0e38\u0e21\u0e0a\u0e19 [URL : #]<\/div> <div>  \n                <a href=\"javascript:void(0)\" data-id=\"19\" class=\"Cupdate\" data-name=\"\u0e02\u0e49\u0e2d\u0e21\u0e39\u0e25\u0e02\u0e48\u0e32\u0e27\u0e2a\u0e32\u0e23\u0e2a\u0e39\u0e48\u0e0a\u0e38\u0e21\u0e0a\u0e19\" data-slug=\"#\" style=\"height: unset;font-size: 16px; margin: 0 5px;\"><i class=\"mdi mdi-pencil\"><\/i><\/a>\n                <a href=\"javascript:void(0)\" data-id=\"19\" class=\"Cdelete\" style=\"height: unset;font-size: 16px; margin: 0 5px;\"><i class=\"mdi mdi-close\"><\/i><\/a>  \n                <\/div> <\/div>"},{"id":20,"content":"<div class=\"d-flex\"> <div class=\"mr-auto contentID-20\"> ID : 20 \u0e1c\u0e25\u0e07\u0e32\u0e19\u0e41\u0e25\u0e30\u0e1a\u0e23\u0e34\u0e01\u0e32\u0e23 [URL : #]<\/div> <div>  \n                <a href=\"javascript:void(0)\" data-id=\"20\" class=\"Cupdate\" data-name=\"\u0e1c\u0e25\u0e07\u0e32\u0e19\u0e41\u0e25\u0e30\u0e1a\u0e23\u0e34\u0e01\u0e32\u0e23\" data-slug=\"#\" style=\"height: unset;font-size: 16px; margin: 0 5px;\"><i class=\"mdi mdi-pencil\"><\/i><\/a>\n                <a href=\"javascript:void(0)\" data-id=\"20\" class=\"Cdelete\" style=\"height: unset;font-size: 16px; margin: 0 5px;\"><i class=\"mdi mdi-close\"><\/i><\/a>  \n                <\/div> <\/div>"},{"id":21,"content":"<div class=\"d-flex\"> <div class=\"mr-auto contentID-21\"> ID : 21 \u0e1a\u0e23\u0e34\u0e01\u0e32\u0e23\u0e27\u0e34\u0e0a\u0e32\u0e01\u0e32\u0e23 [URL : #]<\/div> <div>  \n                <a href=\"javascript:void(0)\" data-id=\"21\" class=\"Cupdate\" data-name=\"\u0e1a\u0e23\u0e34\u0e01\u0e32\u0e23\u0e27\u0e34\u0e0a\u0e32\u0e01\u0e32\u0e23\" data-slug=\"#\" style=\"height: unset;font-size: 16px; margin: 0 5px;\"><i class=\"mdi mdi-pencil\"><\/i><\/a>\n                <a href=\"javascript:void(0)\" data-id=\"21\" class=\"Cdelete\" style=\"height: unset;font-size: 16px; margin: 0 5px;\"><i class=\"mdi mdi-close\"><\/i><\/a>  \n                <\/div> <\/div>"},{"id":22,"content":"<div class=\"d-flex\"> <div class=\"mr-auto contentID-22\"> ID : 22 \u0e07\u0e32\u0e19\u0e27\u0e34\u0e08\u0e31\u0e22 [URL : #]<\/div> <div>  \n                <a href=\"javascript:void(0)\" data-id=\"22\" class=\"Cupdate\" data-name=\"\u0e07\u0e32\u0e19\u0e27\u0e34\u0e08\u0e31\u0e22\" data-slug=\"#\" style=\"height: unset;font-size: 16px; margin: 0 5px;\"><i class=\"mdi mdi-pencil\"><\/i><\/a>\n                <a href=\"javascript:void(0)\" data-id=\"22\" class=\"Cdelete\" style=\"height: unset;font-size: 16px; margin: 0 5px;\"><i class=\"mdi mdi-close\"><\/i><\/a>  \n                <\/div> <\/div>"},{"id":23,"content":"<div class=\"d-flex\"> <div class=\"mr-auto contentID-23\"> ID : 23 \u0e21\u0e32\u0e15\u0e23\u0e10\u0e32\u0e19SOPs [URL : #]<\/div> <div>  \n                <a href=\"javascript:void(0)\" data-id=\"23\" class=\"Cupdate\" data-name=\"\u0e21\u0e32\u0e15\u0e23\u0e10\u0e32\u0e19SOPs\" data-slug=\"#\" style=\"height: unset;font-size: 16px; margin: 0 5px;\"><i class=\"mdi mdi-pencil\"><\/i><\/a>\n                <a href=\"javascript:void(0)\" data-id=\"23\" class=\"Cdelete\" style=\"height: unset;font-size: 16px; margin: 0 5px;\"><i class=\"mdi mdi-close\"><\/i><\/a>  \n                <\/div> <\/div>"},{"id":24,"content":"<div class=\"d-flex\"> <div class=\"mr-auto contentID-24\"> ID : 24 \u0e14\u0e32\u0e27\u0e19\u0e4c\u0e42\u0e2b\u0e25\u0e14\u0e40\u0e2d\u0e01\u0e2a\u0e32\u0e23\/\u0e41\u0e1a\u0e1a\u0e1f\u0e2d\u0e23\u0e4c\u0e21 [URL : #]<\/div> <div>  \n                <a href=\"javascript:void(0)\" data-id=\"24\" class=\"Cupdate\" data-name=\"\u0e14\u0e32\u0e27\u0e19\u0e4c\u0e42\u0e2b\u0e25\u0e14\u0e40\u0e2d\u0e01\u0e2a\u0e32\u0e23\/\u0e41\u0e1a\u0e1a\u0e1f\u0e2d\u0e23\u0e4c\u0e21\" data-slug=\"#\" style=\"height: unset;font-size: 16px; margin: 0 5px;\"><i class=\"mdi mdi-pencil\"><\/i><\/a>\n                <a href=\"javascript:void(0)\" data-id=\"24\" class=\"Cdelete\" style=\"height: unset;font-size: 16px; margin: 0 5px;\"><i class=\"mdi mdi-close\"><\/i><\/a>  \n                <\/div> <\/div>"},{"id":25,"content":"<div class=\"d-flex\"> <div class=\"mr-auto contentID-25\"> ID : 25 \u0e01\u0e32\u0e23\u0e08\u0e31\u0e14\u0e01\u0e32\u0e23\u0e04\u0e27\u0e32\u0e21\u0e23\u0e39\u0e49 (KM) [URL : #]<\/div> <div>  \n                <a href=\"javascript:void(0)\" data-id=\"25\" class=\"Cupdate\" data-name=\"\u0e01\u0e32\u0e23\u0e08\u0e31\u0e14\u0e01\u0e32\u0e23\u0e04\u0e27\u0e32\u0e21\u0e23\u0e39\u0e49 (KM)\" data-slug=\"#\" style=\"height: unset;font-size: 16px; margin: 0 5px;\"><i class=\"mdi mdi-pencil\"><\/i><\/a>\n                <a href=\"javascript:void(0)\" data-id=\"25\" class=\"Cdelete\" style=\"height: unset;font-size: 16px; margin: 0 5px;\"><i class=\"mdi mdi-close\"><\/i><\/a>  \n                <\/div> <\/div>"}]
            }
        );
    });


    $(document).on('click', '.Cupdate', function(event) {
        var id = $(this)[0].dataset.id;
        var name = $(this)[0].dataset.name;
        var slug = $(this)[0].dataset.slug;
        $('#hiddenID').val(id);
        $('input[name=UPmenu_name]').val(name);
        $('input[name=UPmenu_slug]').val(slug);
        $('#ModalUpdate').modal('show');
    });

    $(document).on('click', '#upDditem', function(event) {
        var hiddenID = $('#hiddenID').val();
        var UPmenu_name = $('input[name=UPmenu_name]').val();
        var UPmenu_slug = $('input[name=UPmenu_slug]').val();
        if (UPmenu_name == "" && UPmenu_slug == "") {
            $('input[name=UPmenu_name]').focus();
            return false;
        }
        $.post("{{ route('update.menu') }}", {
                '_token': "{{ csrf_token() }}",
                'id': hiddenID,
                menu_name: UPmenu_name,
                menu_slug: UPmenu_slug,
            },
            function(data) { 
                $('.contentID-' + hiddenID).text(' ID : ' + hiddenID + ' ' + UPmenu_name + ' [URL : ' + UPmenu_slug + ']');
                $('#hiddenID').val("");
                $('#ModalUpdate').modal('hide'); ;
            }
        ); 
    });

    $(document).on('click', '.Cdelete', function(event) {
        var id = $(this)[0].dataset.id; 
        $.post("{{ route('delete.menu') }}", {
                '_token': "{{ csrf_token() }}",
                'id': id, 
            },
            function(data) { 
                $('.dd').nestable('remove', id);
                getDataMenu("Y");
            }
        ); 
    });
</script>
@endsection