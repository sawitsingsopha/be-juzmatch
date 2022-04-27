<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/talent/v4/tenant_service.proto

namespace GPBMetadata\Google\Cloud\Talent\V4;

class TenantService
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
        \GPBMetadata\Google\Cloud\Talent\V4\Common::initOnce();
        \GPBMetadata\Google\Cloud\Talent\V4\Tenant::initOnce();
        \GPBMetadata\Google\Protobuf\GPBEmpty::initOnce();
        \GPBMetadata\Google\Protobuf\FieldMask::initOnce();
        $pool->internalAddGeneratedFile(
            '
�
+google/cloud/talent/v4/tenant_service.protogoogle.cloud.talent.v4google/api/client.protogoogle/api/field_behavior.protogoogle/api/resource.proto#google/cloud/talent/v4/common.proto#google/cloud/talent/v4/tenant.protogoogle/protobuf/empty.proto google/protobuf/field_mask.proto"�
CreateTenantRequestC
parent (	B3�A�A-
+cloudresourcemanager.googleapis.com/Project3
tenant (2.google.cloud.talent.v4.TenantB�A"D
GetTenantRequest0
name (	B"�A�A
jobs.googleapis.com/Tenant"{
UpdateTenantRequest3
tenant (2.google.cloud.talent.v4.TenantB�A/
update_mask (2.google.protobuf.FieldMask"G
DeleteTenantRequest0
name (	B"�A�A
jobs.googleapis.com/Tenant"�
ListTenantsRequestC
parent (	B3�A�A-
+cloudresourcemanager.googleapis.com/Project

page_token (	
	page_size ("�
ListTenantsResponse/
tenants (2.google.cloud.talent.v4.Tenant
next_page_token (	:
metadata (2(.google.cloud.talent.v4.ResponseMetadata2�
TenantService�
CreateTenant+.google.cloud.talent.v4.CreateTenantRequest.google.cloud.talent.v4.Tenant"?���)"/v4/{parent=projects/*}/tenants:tenant�Aparent,tenant�
	GetTenant(.google.cloud.talent.v4.GetTenantRequest.google.cloud.talent.v4.Tenant".���!/v4/{name=projects/*/tenants/*}�Aname�
UpdateTenant+.google.cloud.talent.v4.UpdateTenantRequest.google.cloud.talent.v4.Tenant"K���02&/v4/{tenant.name=projects/*/tenants/*}:tenant�Atenant,update_mask�
DeleteTenant+.google.cloud.talent.v4.DeleteTenantRequest.google.protobuf.Empty".���!*/v4/{name=projects/*/tenants/*}�Aname�
ListTenants*.google.cloud.talent.v4.ListTenantsRequest+.google.cloud.talent.v4.ListTenantsResponse"0���!/v4/{parent=projects/*}/tenants�Aparentl�Ajobs.googleapis.com�AShttps://www.googleapis.com/auth/cloud-platform,https://www.googleapis.com/auth/jobsBv
com.google.cloud.talent.v4BTenantServiceProtoPZ<google.golang.org/genproto/googleapis/cloud/talent/v4;talent�CTSbproto3'
        , true);

        static::$is_initialized = true;
    }
}

