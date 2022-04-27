<?php namespace PHPMaker2022\juzmatch; ?>
<!-- push notification dialog -->
<div id="ew-push-notification-dialog" class="modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-sm-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
            </div>
            <div class="modal-body">
                <form id="ew-push-notification-form" class="ew-form" >
                    <?php if (Config("CHECK_TOKEN")) { ?>
                    <input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
                    <input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
                    <?php } ?>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label ew-label" for="notification-title"><?= $Language->phrase("PushNotificationFormTitle") ?></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control ew-form-control w-100" name="title" id="notification-title">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label ew-label" for="notification-body"><?= $Language->phrase("PushNotificationFormBody") ?></label>
                        <div class="col-sm-8">
                            <textarea class="form-control ew-form-control" rows="6" name="body" id="notification-body"></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary ew-btn"><?= $Language->phrase("SendPushNotificationBtn") ?></button>
                <button type="button" class="btn btn-default ew-btn" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
            </div>
        </div>
    </div>
</div>
