<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/managedidentities/v1beta1/resource.proto

namespace GPBMetadata\Google\Cloud\Managedidentities\V1Beta1;

class Resource
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        \GPBMetadata\Google\Protobuf\Timestamp::initOnce();
        \GPBMetadata\Google\Api\Annotations::initOnce();
        $pool->internalAddGeneratedFile(
            '
�
5google/cloud/managedidentities/v1beta1/resource.proto&google.cloud.managedidentities.v1beta1google/api/annotations.proto"�
Domain
name (	J
labels (2:.google.cloud.managedidentities.v1beta1.Domain.LabelsEntry
authorized_networks (	
reserved_ip_range (	
	locations (	
admin (	
fqdn
 (	/
create_time (2.google.protobuf.Timestamp/
update_time (2.google.protobuf.TimestampC
state (24.google.cloud.managedidentities.v1beta1.Domain.State
status_message (	=
trusts (2-.google.cloud.managedidentities.v1beta1.Trust-
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
UNAVAILABLE"�
Trust
target_domain_name (	K

trust_type (27.google.cloud.managedidentities.v1beta1.Trust.TrustTypeU
trust_direction (2<.google.cloud.managedidentities.v1beta1.Trust.TrustDirection 
selective_authentication (
target_dns_ip_addresses (	
trust_handshake_secret (	/
create_time (2.google.protobuf.Timestamp/
update_time (2.google.protobuf.TimestampB
state	 (23.google.cloud.managedidentities.v1beta1.Trust.State
state_description (	=
last_trust_heartbeat_time (2.google.protobuf.Timestamp"i
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
BIDIRECTIONALB�
*com.google.cloud.managedidentities.v1beta1BResourceProtoPZWgoogle.golang.org/genproto/googleapis/cloud/managedidentities/v1beta1;managedidentities�&Google.Cloud.ManagedIdentities.V1Beta1�&Google\\Cloud\\ManagedIdentities\\V1beta1�)Google::Cloud::ManagedIdentities::V1beta1bproto3'
        , true);

        static::$is_initialized = true;
    }
}

