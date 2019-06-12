<?php include __DIR__. '/header.php'; ?>

<style>
    .note {
        font-size: 10px;
    }
    .failed {
        color:red;
        cursor:pointer;
    }

    .sent {
        color:green;
        cursor:pointer;
    }

</style>

<div class="jumbotron text-center" style="margin-bottom:0">
    <h1>Bulk Sms Send Final List</h1>
    <a href="/">Go Back</a>
</div>

<div class="row">

    <div class="col-md-1"></div>
    <div class="col-md-10">

            <div class="form-group">
                <label for="sms_message">Entered Sms Body</label>
                <textarea required name="sms_message" id="sms_message" rows="3" class="form-control" disabled><?=$messageBody?></textarea>
                <span class="note">Characters : <span id="character_count"><?=strlen($messageBody)?></span></span>
            </div>

            <div style="margin-bottom:15px;overflow:auto;">
                <p style="float:left;">Phone numbers list</p> 
                <button type="button" class="btn btn-success" style="float:right;" id="send-btn">
                    <span style="display:none" id="send-btn-processing"><i class="fa fa-refresh fa-spin"></i>&nbsp;</span>
                    <span>Send</span>
                </button>
            </div>
            
            <table class="table table-bordered">
                <thead>
                <tr>
                    <? foreach($header as $title): ?>
                    <th><?=$title?></th>
                    <? endforeach; ?>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                    <? foreach($records as $index => $data): ?>
                    <tr class="record-row-<?=$index?>">
                        <td><?=$data[0]?></td>
                        <td><?=$data[1]?></td>
                        <td class="phone-number" data-row-index="<?=$index?>" data-phone-number="<?=$data[2]?>"><?=$data[2]?></td>
                        <td>
                            <span class="status not-processed">...</span>
                            <i class="fa fa-refresh fa-spin status processing" style="display:none"></i>
                            <i class="fa fa-times-circle failed status" style="display:none"></i>
                            <i class="fa fa-check-circle sent status" style="display:none"></i>
                        </td>
                    </tr>
                    <? endforeach; ?>
                </tbody>
            </table>


        
    </div>
    <div class="col-md-1"></div>

</div>


<script>
    $(document).ready(function() {

        var message = $("#sms_message").val();
        var phonenumbersCount = $('.phone-number').length;
        var sendBtn = $("#send-btn");

        sendBtn.on('click', function(){

            sendBtn.attr("disabled", true).find('#send-btn-processing').show();

            var counter = 0;

            $('.phone-number').each(async function(rowIndex, item){
                
                //console.log(rowIndex, $(item).data('phone-number'));
                $(item).parent().find('.status').hide();
                $(item).parent().find('.processing').show();

                let response = await sendSms($(item).data('phone-number'), message);

                item.scrollIntoView();
                $(item).parent().find('.status').hide();
                if(response.success) {
                    $(item).parent().find('.sent').show();
                } else {
                    $(item).parent().find('.failed').show().attr('title', response.message);
                }

                if(++counter === phonenumbersCount) {
                    sendBtn.removeAttr("disabled").find('#send-btn-processing').hide();
                }

            });



        });




    });


    function sendSms(number, message)
    {
        return new Promise(function(resolve, reject) {
            $.post("/send_sms.php", {phone_number: number, message_body: message}, function(response){
                resolve(response);
            });
        });
    }


</script>

<?php include __DIR__. '/footer.php'; ?>