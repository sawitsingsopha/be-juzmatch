<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/managedidentities/v1/resource.proto

namespace GPBMetadata\Google\Cloud\Managedidentities\V1;

class Resource
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
�
0google/cloud/managedidentities/v1/resource.proto!google.cloud.managedidentities.v1google/api/resource.protogoogle/protobuf/timestamp.protogoogle/api/annotations.proto"�
Domain
name (	B�AJ
labels (25.google.cloud.managedidentities.v1.Domain.LabelsEntryB�A 
authorized_networks (	B�A
reserved_ip_range (	B�A
	locations (	B�A
admin (	B�A
fqdn
 (	B�A4
create_time (2.google.protobuf.TimestampB�A4
update_time (2.google.protobuf.TimestampB�AC
state (2/.google.cloud.managedidentities.v1.Domain.StateB�A
status_message (	B�A=
trusts (2(.google.cloud.managedidentities.v1.TrustB�A-
LabelsEntry
key (	
value (	:8"�
State
STATE_UNSPECIFIED 
CREATING	
READY
UPDATING
DELETING
	REPAIRING
PERFORMING_MAINTENANCE
UNAVAILABLE:f�Ac
\'managedidentities.googleapis.com/Domain8projects/{project}/locations/{location}/domains/{domain}"�
Trust
target_domain_name (	B�AK

trust_type (22.google.cloud.managedidentities.v1.Trust.TrustTypeB�AU
trust_direction (27.google.cloud.managedidentities.v1.Trust.TrustDirectionB�A%
selective_authentication (B�A$
target_dns_ip_addresses (	B�A#
trust_handshake_secret (	B�A4
create_time (2.google.protobuf.TimestampB�A4
update_time (2.google.protobuf.TimestampB�AB
state	 (2..google.cloud.managedidentities.v1.Trust.StateB�A
state_description (	B�AB
last_trust_heartbeat_time (2.google.protobuf.TimestampB�A"i
State
STATE_UNSPECIFIED 
CREATING
UPDATING
DELETING
	CONNECTED
DISCONNECTED"A
	TrustType
TRUST_TYPE_UNSPECIFIED 

FOREST
EXTERNAL"_
TrustDirection
TRUST_DIRECTION_UNSPECIFIED 
INBOUND
OUTBOUND
BIDIRECTIONALB�
%com.google.cloud.managedidentities.v1BResourceProtoPZRgoogle.golang.org/genproto/googleapis/cloud/managedidentities/v1;managedidentities�!Google.Cloud.ManagedIdentities.V1�!Google\\Cloud\\ManagedIdentities\\V1�$Google::Cloud::ManagedIdentities::V1bproto3'
        , true);

        static::$is_initialized = true;
    }
}

