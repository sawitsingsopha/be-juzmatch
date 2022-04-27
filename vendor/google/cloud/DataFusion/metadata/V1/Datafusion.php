<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/datafusion/v1/datafusion.proto

namespace GPBMetadata\Google\Cloud\Datafusion\V1;

class Datafusion
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
        \GPBMetadata\Google\Longrunning\Operations::initOnce();
        \GPBMetadata\Google\Protobuf\FieldMask::initOnce();
        \GPBMetadata\Google\Protobuf\Timestamp::initOnce();
        $pool->internalAddGeneratedFile(
            '
�)
+google/cloud/datafusion/v1/datafusion.protogoogle.cloud.datafusion.v1google/api/client.protogoogle/api/field_behavior.protogoogle/api/resource.proto#google/longrunning/operations.proto google/protobuf/field_mask.protogoogle/protobuf/timestamp.proto"7
NetworkConfig
network (	
ip_allocation (	"V
Version
version_number (	
default_version (
available_features (	"�
AcceleratorQ
accelerator_type (27.google.cloud.datafusion.v1.Accelerator.AcceleratorType<
state (2-.google.cloud.datafusion.v1.Accelerator.State"_
AcceleratorType 
ACCELERATOR_TYPE_UNSPECIFIED 
CDC

HEALTHCARE
CCAI_INSIGHTS"F
State
STATE_UNSPECIFIED 
ENABLED
DISABLED
UNKNOWN"(
CryptoKeyConfig
key_reference (	"�
Instance
name (	B�A
description (	<
type (2).google.cloud.datafusion.v1.Instance.TypeB�A"
enable_stackdriver_logging (%
enable_stackdriver_monitoring (
private_instance (A
network_config (2).google.cloud.datafusion.v1.NetworkConfig@
labels (20.google.cloud.datafusion.v1.Instance.LabelsEntryB
options	 (21.google.cloud.datafusion.v1.Instance.OptionsEntry4
create_time
 (2.google.protobuf.TimestampB�A4
update_time (2.google.protobuf.TimestampB�A>
state (2*.google.cloud.datafusion.v1.Instance.StateB�A
state_message (	B�A
service_endpoint (	B�A
zone (	
version (	
service_account (	B�A
display_name (	>
available_version (2#.google.cloud.datafusion.v1.Version
api_endpoint (	B�A

gcs_bucket (	B�A=
accelerators (2\'.google.cloud.datafusion.v1.Accelerator
p4_service_account (	B�A
tenant_project_id (	B�A 
dataproc_service_account (	
enable_rbac (F
crypto_key_config (2+.google.cloud.datafusion.v1.CryptoKeyConfig-
LabelsEntry
key (	
value (	:8.
OptionsEntry
key (	
value (	:8"F
Type
TYPE_UNSPECIFIED 	
BASIC

ENTERPRISE
	DEVELOPER"�
State
STATE_UNSPECIFIED 
CREATING

ACTIVE

FAILED
DELETING
	UPGRADING

RESTARTING
UPDATING
AUTO_UPDATING
AUTO_UPGRADING	:e�Ab
"datafusion.googleapis.com/Instance<projects/{project}/locations/{location}/instances/{instance}"o
ListInstancesRequest
parent (	
	page_size (

page_token (	
filter (	
order_by (	"~
ListInstancesResponse7
	instances (2$.google.cloud.datafusion.v1.Instance
next_page_token (	
unreachable (	"u
ListAvailableVersionsRequest
parent (	B�A
	page_size (

page_token (	
latest_patch_only ("y
ListAvailableVersionsResponse?
available_versions (2#.google.cloud.datafusion.v1.Version
next_page_token (	""
GetInstanceRequest
name (	"t
CreateInstanceRequest
parent (	
instance_id (	6
instance (2$.google.cloud.datafusion.v1.Instance"%
DeleteInstanceRequest
name (	"�
UpdateInstanceRequest6
instance (2$.google.cloud.datafusion.v1.Instance/
update_mask (2.google.protobuf.FieldMask"&
RestartInstanceRequest
name (	"�
OperationMetadata/
create_time (2.google.protobuf.Timestamp,
end_time (2.google.protobuf.Timestamp
target (	
verb (	
status_detail (	
requested_cancellation (
api_version (	^
additional_status (2C.google.cloud.datafusion.v1.OperationMetadata.AdditionalStatusEntry7
AdditionalStatusEntry
key (	
value (	:82�

DataFusion�
ListAvailableVersions8.google.cloud.datafusion.v1.ListAvailableVersionsRequest9.google.cloud.datafusion.v1.ListAvailableVersionsResponse"=���.,/v1/{parent=projects/*/locations/*}/versions�Aparent�
ListInstances0.google.cloud.datafusion.v1.ListInstancesRequest1.google.cloud.datafusion.v1.ListInstancesResponse"5���/-/v1/{parent=projects/*/locations/*}/instances�
GetInstance..google.cloud.datafusion.v1.GetInstanceRequest$.google.cloud.datafusion.v1.Instance"5���/-/v1/{name=projects/*/locations/*/instances/*}�
CreateInstance1.google.cloud.datafusion.v1.CreateInstanceRequest.google.longrunning.Operation"}���9"-/v1/{parent=projects/*/locations/*}/instances:instance�Aparent,instance,instance_id�A
InstanceOperationMetadata�
DeleteInstance1.google.cloud.datafusion.v1.DeleteInstanceRequest.google.longrunning.Operation"i���/*-/v1/{name=projects/*/locations/*/instances/*}�Aname�A*
google.protobuf.EmptyOperationMetadata�
UpdateInstance1.google.cloud.datafusion.v1.UpdateInstanceRequest.google.longrunning.Operation"���B26/v1/{instance.name=projects/*/locations/*/instances/*}:instance�Ainstance,update_mask�A
InstanceOperationMetadata�
RestartInstance2.google.cloud.datafusion.v1.RestartInstanceRequest.google.longrunning.Operation"`���:"5/v1/{name=projects/*/locations/*/instances/*}:restart:*�A
InstanceOperationMetadataM�Adatafusion.googleapis.com�A.https://www.googleapis.com/auth/cloud-platformB�
com.google.cloud.datafusion.v1PZDgoogle.golang.org/genproto/googleapis/cloud/datafusion/v1;datafusion�Google.Cloud.DataFusion.V1�Google\\Cloud\\DataFusion\\V1�Google::Cloud::DataFusion::V1bproto3'
        , true);

        static::$is_initialized = true;
    }
}

