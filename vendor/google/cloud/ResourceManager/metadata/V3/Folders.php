<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/resourcemanager/v3/folders.proto

namespace GPBMetadata\Google\Cloud\Resourcemanager\V3;

class Folders
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
        \GPBMetadata\Google\Iam\V1\IamPolicy::initOnce();
        \GPBMetadata\Google\Iam\V1\Policy::initOnce();
        \GPBMetadata\Google\Longrunning\Operations::initOnce();
        \GPBMetadata\Google\Protobuf\FieldMask::initOnce();
        \GPBMetadata\Google\Protobuf\Timestamp::initOnce();
        $pool->internalAddGeneratedFile(
            '
�!
-google/cloud/resourcemanager/v3/folders.protogoogle.cloud.resourcemanager.v3google/api/client.protogoogle/api/field_behavior.protogoogle/api/resource.protogoogle/iam/v1/iam_policy.protogoogle/iam/v1/policy.proto#google/longrunning/operations.proto google/protobuf/field_mask.protogoogle/protobuf/timestamp.proto"�
Folder
name (	B�A
parent (	B�A
display_name (	A
state (2-.google.cloud.resourcemanager.v3.Folder.StateB�A4
create_time (2.google.protobuf.TimestampB�A4
update_time (2.google.protobuf.TimestampB�A4
delete_time (2.google.protobuf.TimestampB�A
etag (	B�A"@
State
STATE_UNSPECIFIED 

ACTIVE
DELETE_REQUESTED:D�AA
*cloudresourcemanager.googleapis.com/Folderfolders/{folder}R"T
GetFolderRequest@
name (	B2�A�A,
*cloudresourcemanager.googleapis.com/Folder"{
ListFoldersRequest
parent (	B	�A�A*
	page_size (B�A

page_token (	B�A
show_deleted (B�A"h
ListFoldersResponse8
folders (2\'.google.cloud.resourcemanager.v3.Folder
next_page_token (	"[
SearchFoldersRequest
	page_size (B�A

page_token (	B�A
query (	B�A"j
SearchFoldersResponse8
folders (2\'.google.cloud.resourcemanager.v3.Folder
next_page_token (	"S
CreateFolderRequest<
folder (2\'.google.cloud.resourcemanager.v3.FolderB�A"<
CreateFolderMetadata
display_name (	
parent (	"�
UpdateFolderRequest<
folder (2\'.google.cloud.resourcemanager.v3.FolderB�A4
update_mask (2.google.protobuf.FieldMaskB�A"
UpdateFolderMetadata"|
MoveFolderRequest@
name (	B2�A�A,
*cloudresourcemanager.googleapis.com/Folder%
destination_parent (	B	�A�A*"]
MoveFolderMetadata
display_name (	
source_parent (	
destination_parent (	"W
DeleteFolderRequest@
name (	B2�A�A,
*cloudresourcemanager.googleapis.com/Folder"
DeleteFolderMetadata"Y
UndeleteFolderRequest@
name (	B2�A�A,
*cloudresourcemanager.googleapis.com/Folder"
UndeleteFolderMetadata2�
Folders�
	GetFolder1.google.cloud.resourcemanager.v3.GetFolderRequest\'.google.cloud.resourcemanager.v3.Folder"#���/v3/{name=folders/*}�Aname�
ListFolders3.google.cloud.resourcemanager.v3.ListFoldersRequest4.google.cloud.resourcemanager.v3.ListFoldersResponse"���/v3/folders�Aparent�
SearchFolders5.google.cloud.resourcemanager.v3.SearchFoldersRequest6.google.cloud.resourcemanager.v3.SearchFoldersResponse""���/v3/folders:search�Aquery�
CreateFolder4.google.cloud.resourcemanager.v3.CreateFolderRequest.google.longrunning.Operation"E���"/v3/folders:folder�Afolder�A
FolderCreateFolderMetadata�
UpdateFolder4.google.cloud.resourcemanager.v3.UpdateFolderRequest.google.longrunning.Operation"a���%2/v3/{folder.name=folders/*}:folder�Afolder,update_mask�A
FolderUpdateFolderMetadata�

MoveFolder2.google.cloud.resourcemanager.v3.MoveFolderRequest.google.longrunning.Operation"]���"/v3/{name=folders/*}:move:*�Aname,destination_parent�A
FolderMoveFolderMetadata�
DeleteFolder4.google.cloud.resourcemanager.v3.DeleteFolderRequest.google.longrunning.Operation"D���*/v3/{name=folders/*}�Aname�A
FolderDeleteFolderMetadata�
UndeleteFolder6.google.cloud.resourcemanager.v3.UndeleteFolderRequest.google.longrunning.Operation"R���""/v3/{name=folders/*}:undelete:*�Aname�A 
FolderUndeleteFolderMetadata�
GetIamPolicy".google.iam.v1.GetIamPolicyRequest.google.iam.v1.Policy";���*"%/v3/{resource=folders/*}:getIamPolicy:*�Aresource�
SetIamPolicy".google.iam.v1.SetIamPolicyRequest.google.iam.v1.Policy"B���*"%/v3/{resource=folders/*}:setIamPolicy:*�Aresource,policy�
TestIamPermissions(.google.iam.v1.TestIamPermissionsRequest).google.iam.v1.TestIamPermissionsResponse"M���0"+/v3/{resource=folders/*}:testIamPermissions:*�Aresource,permissions��A#cloudresourcemanager.googleapis.com�Aghttps://www.googleapis.com/auth/cloud-platform,https://www.googleapis.com/auth/cloud-platform.read-onlyB�
#com.google.cloud.resourcemanager.v3BFoldersProtoPZNgoogle.golang.org/genproto/googleapis/cloud/resourcemanager/v3;resourcemanager�Google.Cloud.ResourceManager.V3�Google\\Cloud\\ResourceManager\\V3�"Google::Cloud::ResourceManager::V3bproto3'
        , true);

        static::$is_initialized = true;
    }
}

