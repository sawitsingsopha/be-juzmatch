<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/securitycenter/v1/resource.proto

namespace GPBMetadata\Google\Cloud\Securitycenter\V1;

class Resource
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        \GPBMetadata\Google\Api\FieldBehavior::initOnce();
        \GPBMetadata\Google\Cloud\Securitycenter\V1\Folder::initOnce();
        \GPBMetadata\Google\Api\Annotations::initOnce();
        $pool->internalAddGeneratedFile(
            '
�
-google/cloud/securitycenter/v1/resource.protogoogle.cloud.securitycenter.v1+google/cloud/securitycenter/v1/folder.protogoogle/api/annotations.proto"�
Resource
name (	
project (	
project_display_name (	
parent (	
parent_display_name (	<
folders (2&.google.cloud.securitycenter.v1.FolderB�AB�
"com.google.cloud.securitycenter.v1BResourceProtoPZLgoogle.golang.org/genproto/googleapis/cloud/securitycenter/v1;securitycenter�Google.Cloud.SecurityCenter.V1�Google\\Cloud\\SecurityCenter\\V1�!Google::Cloud::SecurityCenter::V1bproto3'
        , true);

        static::$is_initialized = true;
    }
}

