<?php 
    $from_date = '1900-01-01';
    $to_date = gmdate('Y-m-d H:i:s', time() + 7*3600);

    $from_date = new DateTime($from_date);
    $to_date = new DateTime($to_date);
    $date_array = [];
    for ($date = $from_date; $date <= $to_date; $date->modify('+1 year')) {
        $key = $date->format('Y');
        $date_array[$key] = $key;
    }

    $from_date = new DateTime('1900-01-01');
    $to_date = new DateTime('2050-01-01');
    $date_array_xd = [];
    for ($date = $from_date; $date <= $to_date; $date->modify('+1 year')) {
        $key = $date->format('Y');
        $date_array_xd[$key] = $key;
    }
?>
<div class="showmobile_xemtuoixaydung hidden-lg hidden-md">
    <a class="item-link downs"> Xem tuổi xây dựng
        <i class="fa fa-angle-down"></i>
    </a>
</div>
<div id="xemtuoi">
    <div class="wp_phongthuy_form wp_tuoixaydung wp-tuoixaydung wp-txd">
        <div class="form-title">
            <span>Xem tuổi xây dựng
            </span>
        </div>
        <div class="form-group">
            <label for="name" class="control-label required">Năm sinh gia chủ</label>
            <div class="select">
                <?php echo form_dropdown('namsinh', $date_array, set_value('namsinh'), 'class="ns "');?>
            </div>
        </div>
        <div class="form-group">
            <label for="name" class="control-label required">Năm xây dựng</label>
            <div class="select">
                <?php echo form_dropdown('namxaydung', $date_array_xd, set_value('namxaydung'), 'class="nx "');?>
            </div>
        </div>
        <div class="form-group" style="text-align:center">
            <button class="xem btn btn-primary   xemtuoi" data-catalogueid="13">Xem ngay</button>
        </div>
    </div>
</div>


<script>
    $(document).on('click','.xemtuoi', function(){
        let catalogueid = $(this).attr('data-catalogueid');
        let namsinh = $(this).parents('.wp_phongthuy_form').find('.ns').val()
        let namxaydung = $(this).parents('.wp_phongthuy_form').find('.nx').val()
        let ajaxUrl = "ajax/frontend/dashboard/search_tuoixaydung";
        $.ajax({
            method: "POST",
            url: ajaxUrl,
            data: {catalogueid: catalogueid,namsinh: namsinh,namxaydung: namxaydung},
            dataType: "json",
            cache: false,
            success: function(data){
                if(data.code == 'error'){
                    toastr.error('Không có dữ liệu phù hợp!','Xin vui lòng thử lại!');
                }else{
                    var modal = UIkit.modal("#tuoixaydung");
                    $('.title-modal').text(data.title)
                    $('.desc-modal').html(b64DecodeUnicode(data.description))
                    $('.content-modal-abc').html(b64DecodeUnicode(data.content))
                    modal.show();
                }
            }
        });
    });

    function b64DecodeUnicode(str) {
    // Going backwards: from bytestream, to percent-encoding, to original string.
        return decodeURIComponent(atob(str).split('').map(function(c) {
            return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
        }).join(''));
    }
</script>

<div id="tuoixaydung" class="uk-modal">
    <div class="uk-modal-dialog uk-modal-dialog-blank">
        <div class="content-modal">
            <h2 class="title-modal"></h2>
            <div class="desc-modal"></div>
            <div class="content-modal-abc"></div>
        </div>
    </div>
</div>