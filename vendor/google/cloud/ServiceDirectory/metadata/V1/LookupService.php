<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/servicedirectory/v1/lookup_service.proto

namespace GPBMetadata\Google\Cloud\Servicedirectory\V1;

class LookupService
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        \GPBMetadata\Google\Api\Annotations::initOnce();
        \GPBMetadata\Google\Api\Client::initOnce();
        \GPBMetadata\Google\Api\FieldBehavior::initOnce();
        \GPBMetadata\Google\Api\Resource::initOnce();
        \GPBMetadata\Google\Cloud\Servicedirectory\V1\Service::initOnce();
        $pool->internalAddGeneratedFile(
            '
�
5google/cloud/servicedirectory/v1/lookup_service.proto google.cloud.servicedirectory.v1google/api/client.protogoogle/api/field_behavior.protogoogle/api/resource.proto.google/cloud/servicedirectory/v1/service.proto"�
ResolveServiceRequest=
name (	B/�A�A)
\'servicedirectory.googleapis.com/Service
max_endpoints (B�A
endpoint_filter (	B�A"T
ResolveServiceResponse:
service (2).google.cloud.servicedirectory.v1.Service2�
LookupService�
ResolveService7.google.cloud.servicedirectory.v1.ResolveServiceRequest8.google.cloud.servicedirectory.v1.ResolveServiceResponse"L���F"A/v1/{name=projects/*/locations/*/namespaces/*/services/*}:resolve:*S�Aservicedirectory.googleapis.com�A.https://www.googleapis.com/auth/cloud-platformB�
$com.google.cloud.servicedirectory.v1BLookupServiceProtoPZPgoogle.golang.org/genproto/googleapis/cloud/servicedirectory/v1;servicedirectory�� Google.Cloud.ServiceDirectory.V1� Google\\Cloud\\ServiceDirectory\\V1�#Google::Cloud::ServiceDirectory::V1bproto3'
        , true);

        static::$is_initialized = true;
    }
}

