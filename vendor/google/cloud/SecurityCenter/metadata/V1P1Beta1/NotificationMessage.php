<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/securitycenter/v1p1beta1/notification_message.proto

namespace GPBMetadata\Google\Cloud\Securitycenter\V1P1Beta1;

class NotificationMessage
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        \GPBMetadata\Google\Cloud\Securitycenter\V1P1Beta1\Finding::initOnce();
        \GPBMetadata\Google\Cloud\Securitycenter\V1P1Beta1\Resource::initOnce();
        \GPBMetadata\Google\Api\Annotations::initOnce();
        $pool->internalAddGeneratedFile(
            '
�
@google/cloud/securitycenter/v1p1beta1/notification_message.proto%google.cloud.securitycenter.v1p1beta14google/cloud/securitycenter/v1p1beta1/resource.protogoogle/api/annotations.proto"�
NotificationMessage 
notification_config_name (	A
finding (2..google.cloud.securitycenter.v1p1beta1.FindingH A
resource (2/.google.cloud.securitycenter.v1p1beta1.ResourceB
eventB�
)com.google.cloud.securitycenter.v1p1beta1PZSgoogle.golang.org/genproto/googleapis/cloud/securitycenter/v1p1beta1;securitycenter�%Google.Cloud.SecurityCenter.V1P1Beta1�%Google\\Cloud\\SecurityCenter\\V1p1beta1�(Google::Cloud::SecurityCenter::V1p1beta1bproto3'
        , true);

        static::$is_initialized = true;
    }
}

