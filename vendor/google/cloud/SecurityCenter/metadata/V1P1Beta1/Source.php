<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/securitycenter/v1p1beta1/source.proto

namespace GPBMetadata\Google\Cloud\Securitycenter\V1P1Beta1;

class Source
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        \GPBMetadata\Google\Api\Resource::initOnce();
        \GPBMetadata\Google\Api\Annotations::initOnce();
        $pool->internalAddGeneratedFile(
            '
�
2google/cloud/securitycenter/v1p1beta1/source.proto%google.cloud.securitycenter.v1p1beta1google/api/annotations.proto"�
Source
name (	
display_name (	
description (	
canonical_name (	:��A�
$securitycenter.googleapis.com/Source-organizations/{organization}/sources/{source}!folders/{folder}/sources/{source}#projects/{project}/sources/{source}B�
)com.google.cloud.securitycenter.v1p1beta1PZSgoogle.golang.org/genproto/googleapis/cloud/securitycenter/v1p1beta1;securitycenter�%Google.Cloud.SecurityCenter.V1P1Beta1�%Google\\Cloud\\SecurityCenter\\V1p1beta1�(Google::Cloud::SecurityCenter::V1p1beta1bproto3'
        , true);

        static::$is_initialized = true;
    }
}

