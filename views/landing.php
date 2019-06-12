<?php include __DIR__. '/header.php'; ?>

<style>
    .note {
        font-size: 10px;
    }
</style>

<div class="jumbotron text-center" style="margin-bottom:0">
    <h1>Bulk Sms Send Script</h1>
</div>

<div class="row">

    <div class="col-md-3"></div>
    <div class="col-md-6">
        <form action="/process_sms.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="sms_message">Enter Sms Body</label>
                <textarea required name="sms_message" id="sms_message" rows="3" class="form-control"></textarea>
                <span class="note">Characters : <span id="character_count">0</span></span>
            </div>
            <div class="form-group">
                <label for="excel_file">Upload .xlsx file</label>
                <input required type="file" id="excel_file" name="excel_file" class="form-control-file border" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <div class="col-md-3"></div>

</div>

<script>
    $(document).ready(function() {

        var cCountElem = $("#character_count");
      
        $('textarea[name=sms_message]').on('keyup', function() {
            cCountElem.text($(this).val().length);
        });


    });
</script>

<?php include __DIR__. '/footer.php'; ?>