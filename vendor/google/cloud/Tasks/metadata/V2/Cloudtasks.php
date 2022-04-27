<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/tasks/v2/cloudtasks.proto

namespace GPBMetadata\Google\Cloud\Tasks\V2;

class Cloudtasks
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
        \GPBMetadata\Google\Cloud\Tasks\V2\Queue::initOnce();
        \GPBMetadata\Google\Cloud\Tasks\V2\Task::initOnce();
        \GPBMetadata\Google\Iam\V1\IamPolicy::initOnce();
        \GPBMetadata\Google\Iam\V1\Policy::initOnce();
        \GPBMetadata\Google\Protobuf\GPBEmpty::initOnce();
        \GPBMetadata\Google\Protobuf\FieldMask::initOnce();
        $pool->internalAddGeneratedFile(
            '
�%
&google/cloud/tasks/v2/cloudtasks.protogoogle.cloud.tasks.v2google/api/client.protogoogle/api/field_behavior.protogoogle/api/resource.proto!google/cloud/tasks/v2/queue.proto google/cloud/tasks/v2/task.protogoogle/iam/v1/iam_policy.protogoogle/iam/v1/policy.protogoogle/protobuf/empty.proto google/protobuf/field_mask.proto"�
ListQueuesRequest7
parent (	B\'�A�A!cloudtasks.googleapis.com/Queue
filter (	
	page_size (

page_token (	"[
ListQueuesResponse,
queues (2.google.cloud.tasks.v2.Queue
next_page_token (	"H
GetQueueRequest5
name (	B\'�A�A!
cloudtasks.googleapis.com/Queue"
CreateQueueRequest7
parent (	B\'�A�A!cloudtasks.googleapis.com/Queue0
queue (2.google.cloud.tasks.v2.QueueB�A"w
UpdateQueueRequest0
queue (2.google.cloud.tasks.v2.QueueB�A/
update_mask (2.google.protobuf.FieldMask"K
DeleteQueueRequest5
name (	B\'�A�A!
cloudtasks.googleapis.com/Queue"J
PurgeQueueRequest5
name (	B\'�A�A!
cloudtasks.googleapis.com/Queue"J
PauseQueueRequest5
name (	B\'�A�A!
cloudtasks.googleapis.com/Queue"K
ResumeQueueRequest5
name (	B\'�A�A!
cloudtasks.googleapis.com/Queue"�
ListTasksRequest6
parent (	B&�A�A cloudtasks.googleapis.com/Task7
response_view (2 .google.cloud.tasks.v2.Task.View
	page_size (

page_token (	"X
ListTasksResponse*
tasks (2.google.cloud.tasks.v2.Task
next_page_token (	"
GetTaskRequest4
name (	B&�A�A 
cloudtasks.googleapis.com/Task7
response_view (2 .google.cloud.tasks.v2.Task.View"�
CreateTaskRequest6
parent (	B&�A�A cloudtasks.googleapis.com/Task.
task (2.google.cloud.tasks.v2.TaskB�A7
response_view (2 .google.cloud.tasks.v2.Task.View"I
DeleteTaskRequest4
name (	B&�A�A 
cloudtasks.googleapis.com/Task"
RunTaskRequest4
name (	B&�A�A 
cloudtasks.googleapis.com/Task7
response_view (2 .google.cloud.tasks.v2.Task.View2�

CloudTasks�

ListQueues(.google.cloud.tasks.v2.ListQueuesRequest).google.cloud.tasks.v2.ListQueuesResponse";���,*/v2/{parent=projects/*/locations/*}/queues�Aparent�
GetQueue&.google.cloud.tasks.v2.GetQueueRequest.google.cloud.tasks.v2.Queue"9���,*/v2/{name=projects/*/locations/*/queues/*}�Aname�
CreateQueue).google.cloud.tasks.v2.CreateQueueRequest.google.cloud.tasks.v2.Queue"H���3"*/v2/{parent=projects/*/locations/*}/queues:queue�Aparent,queue�
UpdateQueue).google.cloud.tasks.v2.UpdateQueueRequest.google.cloud.tasks.v2.Queue"S���920/v2/{queue.name=projects/*/locations/*/queues/*}:queue�Aqueue,update_mask�
DeleteQueue).google.cloud.tasks.v2.DeleteQueueRequest.google.protobuf.Empty"9���,**/v2/{name=projects/*/locations/*/queues/*}�Aname�

PurgeQueue(.google.cloud.tasks.v2.PurgeQueueRequest.google.cloud.tasks.v2.Queue"B���5"0/v2/{name=projects/*/locations/*/queues/*}:purge:*�Aname�

PauseQueue(.google.cloud.tasks.v2.PauseQueueRequest.google.cloud.tasks.v2.Queue"B���5"0/v2/{name=projects/*/locations/*/queues/*}:pause:*�Aname�
ResumeQueue).google.cloud.tasks.v2.ResumeQueueRequest.google.cloud.tasks.v2.Queue"C���6"1/v2/{name=projects/*/locations/*/queues/*}:resume:*�Aname�
GetIamPolicy".google.iam.v1.GetIamPolicyRequest.google.iam.v1.Policy"Q���@";/v2/{resource=projects/*/locations/*/queues/*}:getIamPolicy:*�Aresource�
SetIamPolicy".google.iam.v1.SetIamPolicyRequest.google.iam.v1.Policy"X���@";/v2/{resource=projects/*/locations/*/queues/*}:setIamPolicy:*�Aresource,policy�
TestIamPermissions(.google.iam.v1.TestIamPermissionsRequest).google.iam.v1.TestIamPermissionsResponse"c���F"A/v2/{resource=projects/*/locations/*/queues/*}:testIamPermissions:*�Aresource,permissions�
	ListTasks\'.google.cloud.tasks.v2.ListTasksRequest(.google.cloud.tasks.v2.ListTasksResponse"C���42/v2/{parent=projects/*/locations/*/queues/*}/tasks�Aparent�
GetTask%.google.cloud.tasks.v2.GetTaskRequest.google.cloud.tasks.v2.Task"A���42/v2/{name=projects/*/locations/*/queues/*/tasks/*}�Aname�

CreateTask(.google.cloud.tasks.v2.CreateTaskRequest.google.cloud.tasks.v2.Task"K���7"2/v2/{parent=projects/*/locations/*/queues/*}/tasks:*�Aparent,task�

DeleteTask(.google.cloud.tasks.v2.DeleteTaskRequest.google.protobuf.Empty"A���4*2/v2/{name=projects/*/locations/*/queues/*/tasks/*}�Aname�
RunTask%.google.cloud.tasks.v2.RunTaskRequest.google.cloud.tasks.v2.Task"H���;"6/v2/{name=projects/*/locations/*/queues/*/tasks/*}:run:*�AnameM�Acloudtasks.googleapis.com�A.https://www.googleapis.com/auth/cloud-platformBr
com.google.cloud.tasks.v2BCloudTasksProtoPZ:google.golang.org/genproto/googleapis/cloud/tasks/v2;tasks�TASKSbproto3'
        , true);

        static::$is_initialized = true;
    }
}

