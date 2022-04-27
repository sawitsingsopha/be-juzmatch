<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/networkconnectivity/v1/hub.proto

namespace GPBMetadata\Google\Cloud\Networkconnectivity\V1;

class Hub
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
�4
-google/cloud/networkconnectivity/v1/hub.proto#google.cloud.networkconnectivity.v1google/api/client.protogoogle/api/field_behavior.protogoogle/api/resource.proto#google/longrunning/operations.proto google/protobuf/field_mask.protogoogle/protobuf/timestamp.proto"�
Hub
name (	B�A4
create_time (2.google.protobuf.TimestampB�A4
update_time (2.google.protobuf.TimestampB�AD
labels (24.google.cloud.networkconnectivity.v1.Hub.LabelsEntry
description (	
	unique_id (	B�A>
state	 (2*.google.cloud.networkconnectivity.v1.StateB�AE
routing_vpcs
 (2/.google.cloud.networkconnectivity.v1.RoutingVPC-
LabelsEntry
key (	
value (	:8:[�AX
&networkconnectivity.googleapis.com/Hub.projects/{project}/locations/global/hubs/{hub}">

RoutingVPC0
uri (	B#�A 
compute.googleapis.com/Network"�
Spoke
name (	B�A4
create_time (2.google.protobuf.TimestampB�A4
update_time (2.google.protobuf.TimestampB�AF
labels (26.google.cloud.networkconnectivity.v1.Spoke.LabelsEntry
description (	;
hub (	B.�A�A(
&networkconnectivity.googleapis.com/HubQ
linked_vpn_tunnels (25.google.cloud.networkconnectivity.v1.LinkedVpnTunnelsk
linked_interconnect_attachments (2B.google.cloud.networkconnectivity.v1.LinkedInterconnectAttachmentsn
!linked_router_appliance_instances (2C.google.cloud.networkconnectivity.v1.LinkedRouterApplianceInstances
	unique_id (	B�A>
state (2*.google.cloud.networkconnectivity.v1.StateB�A-
LabelsEntry
key (	
value (	:8:e�Ab
(networkconnectivity.googleapis.com/Spoke6projects/{project}/locations/{location}/spokes/{spoke}"�
ListHubsRequest9
parent (	B)�A�A#
!locations.googleapis.com/Location
	page_size (

page_token (	
filter (	
order_by (	"x
ListHubsResponse6
hubs (2(.google.cloud.networkconnectivity.v1.Hub
next_page_token (	
unreachable (	"M
GetHubRequest<
name (	B.�A�A(
&networkconnectivity.googleapis.com/Hub"�
CreateHubRequest9
parent (	B)�A�A#
!locations.googleapis.com/Location
hub_id (	B�A:
hub (2(.google.cloud.networkconnectivity.v1.HubB�A

request_id (	B�A"�
UpdateHubRequest4
update_mask (2.google.protobuf.FieldMaskB�A:
hub (2(.google.cloud.networkconnectivity.v1.HubB�A

request_id (	B�A"i
DeleteHubRequest<
name (	B.�A�A(
&networkconnectivity.googleapis.com/Hub

request_id (	B�A"�
ListSpokesRequest9
parent (	B)�A�A#
!locations.googleapis.com/Location
	page_size (

page_token (	
filter (	
order_by (	"~
ListSpokesResponse:
spokes (2*.google.cloud.networkconnectivity.v1.Spoke
next_page_token (	
unreachable (	"Q
GetSpokeRequest>
name (	B0�A�A*
(networkconnectivity.googleapis.com/Spoke"�
CreateSpokeRequest9
parent (	B)�A�A#
!locations.googleapis.com/Location
spoke_id (	B�A>
spoke (2*.google.cloud.networkconnectivity.v1.SpokeB�A

request_id (	B�A"�
UpdateSpokeRequest4
update_mask (2.google.protobuf.FieldMaskB�A>
spoke (2*.google.cloud.networkconnectivity.v1.SpokeB�A

request_id (	B�A"m
DeleteSpokeRequest>
name (	B0�A�A*
(networkconnectivity.googleapis.com/Spoke

request_id (	B�A"k
LinkedVpnTunnels3
uris (	B%�A"
 compute.googleapis.com/VpnTunnel"
site_to_site_data_transfer ("�
LinkedInterconnectAttachments@
uris (	B2�A/
-compute.googleapis.com/InterconnectAttachment"
site_to_site_data_transfer ("�
LinkedRouterApplianceInstancesO
	instances (2<.google.cloud.networkconnectivity.v1.RouterApplianceInstance"
site_to_site_data_transfer ("l
RouterApplianceInstance=
virtual_machine (	B$�A!
compute.googleapis.com/Instance

ip_address (	*F
State
STATE_UNSPECIFIED 
CREATING

ACTIVE
DELETING2�

HubService�
ListHubs4.google.cloud.networkconnectivity.v1.ListHubsRequest5.google.cloud.networkconnectivity.v1.ListHubsResponse">���/-/v1/{parent=projects/*/locations/global}/hubs�Aparent�
GetHub2.google.cloud.networkconnectivity.v1.GetHubRequest(.google.cloud.networkconnectivity.v1.Hub"<���/-/v1/{name=projects/*/locations/global/hubs/*}�Aname�
	CreateHub5.google.cloud.networkconnectivity.v1.CreateHubRequest.google.longrunning.Operation"i���4"-/v1/{parent=projects/*/locations/global}/hubs:hub�Aparent,hub,hub_id�A
HubOperationMetadata�
	UpdateHub5.google.cloud.networkconnectivity.v1.UpdateHubRequest.google.longrunning.Operation"k���821/v1/{hub.name=projects/*/locations/global/hubs/*}:hub�Ahub,update_mask�A
HubOperationMetadata�
	DeleteHub5.google.cloud.networkconnectivity.v1.DeleteHubRequest.google.longrunning.Operation"i���/*-/v1/{name=projects/*/locations/global/hubs/*}�Aname�A*
google.protobuf.EmptyOperationMetadata�

ListSpokes6.google.cloud.networkconnectivity.v1.ListSpokesRequest7.google.cloud.networkconnectivity.v1.ListSpokesResponse";���,*/v1/{parent=projects/*/locations/*}/spokes�Aparent�
GetSpoke4.google.cloud.networkconnectivity.v1.GetSpokeRequest*.google.cloud.networkconnectivity.v1.Spoke"9���,*/v1/{name=projects/*/locations/*/spokes/*}�Aname�
CreateSpoke7.google.cloud.networkconnectivity.v1.CreateSpokeRequest.google.longrunning.Operation"n���3"*/v1/{parent=projects/*/locations/*}/spokes:spoke�Aparent,spoke,spoke_id�A
SpokeOperationMetadata�
UpdateSpoke7.google.cloud.networkconnectivity.v1.UpdateSpokeRequest.google.longrunning.Operation"p���920/v1/{spoke.name=projects/*/locations/*/spokes/*}:spoke�Aspoke,update_mask�A
SpokeOperationMetadata�
DeleteSpoke7.google.cloud.networkconnectivity.v1.DeleteSpokeRequest.google.longrunning.Operation"f���,**/v1/{name=projects/*/locations/*/spokes/*}�Aname�A*
google.protobuf.EmptyOperationMetadataV�A"networkconnectivity.googleapis.com�A.https://www.googleapis.com/auth/cloud-platformB�
\'com.google.cloud.networkconnectivity.v1BHubProtoPZVgoogle.golang.org/genproto/googleapis/cloud/networkconnectivity/v1;networkconnectivity�#Google.Cloud.NetworkConnectivity.V1�#Google\\Cloud\\NetworkConnectivity\\V1�&Google::Cloud::NetworkConnectivity::V1�A`
 compute.googleapis.com/VpnTunnel<projects/{project}/regions/{region}/vpnTunnels/{resource_id}�Az
-compute.googleapis.com/InterconnectAttachmentIprojects/{project}/regions/{region}/interconnectAttachments/{resource_id}�AW
compute.googleapis.com/Instance4projects/{project}/zones/{zone}/instances/{instance}�AR
compute.googleapis.com/Network0projects/{project}/global/networks/{resource_id}bproto3'
        , true);

        static::$is_initialized = true;
    }
}

