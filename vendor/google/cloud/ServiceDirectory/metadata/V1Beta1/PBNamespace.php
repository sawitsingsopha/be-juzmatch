<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/servicedirectory/v1beta1/namespace.proto

namespace GPBMetadata\Google\Cloud\Servicedirectory\V1Beta1;

class PBNamespace
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        \GPBMetadata\Google\Api\FieldBehavior::initOnce();
        \GPBMetadata\Google\Api\Resource::initOnce();
        \GPBMetadata\Google\Protobuf\Timestamp::initOnce();
        \GPBMetadata\Google\Api\Annotations::initOnce();
        $pool->internalAddGeneratedFile(
            '
�
5google/cloud/servicedirectory/v1beta1/namespace.proto%google.cloud.servicedirectory.v1beta1google/api/resource.protogoogle/protobuf/timestamp.protogoogle/api/annotations.proto"�
	Namespace
name (	B�AQ
labels (2<.google.cloud.servicedirectory.v1beta1.Namespace.LabelsEntryB�A4
create_time (2.google.protobuf.TimestampB�A4
update_time (2.google.protobuf.TimestampB�A-
LabelsEntry
key (	
value (	:8:n�Ak
)servicedirectory.googleapis.com/Namespace>projects/{project}/locations/{location}/namespaces/{namespace}B�
)com.google.cloud.servicedirectory.v1beta1BNamespaceProtoPZUgoogle.golang.org/genproto/googleapis/cloud/servicedirectory/v1beta1;servicedirectory��%Google.Cloud.ServiceDirectory.V1Beta1�%Google\\Cloud\\ServiceDirectory\\V1beta1�(Google::Cloud::ServiceDirectory::V1beta1bproto3'
        , true);

        static::$is_initialized = true;
    }
}

