<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/firestore/v1/common.proto

namespace GPBMetadata\Google\Firestore\V1;

class Common
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
�
 google/firestore/v1/common.protogoogle.firestore.v1google/api/annotations.proto"#
DocumentMask
field_paths (	"e
Precondition
exists (H 1
update_time (2.google.protobuf.TimestampH B
condition_type"�
TransactionOptionsE
	read_only (20.google.firestore.v1.TransactionOptions.ReadOnlyH G

read_write (21.google.firestore.v1.TransactionOptions.ReadWriteH &
	ReadWrite
retry_transaction (S
ReadOnly/
	read_time (2.google.protobuf.TimestampH B
consistency_selectorB
modeB�
com.google.firestore.v1BCommonProtoPZ<google.golang.org/genproto/googleapis/firestore/v1;firestore�GCFS�Google.Cloud.Firestore.V1�Google\\Cloud\\Firestore\\V1�Google::Cloud::Firestore::V1bproto3'
        , true);

        static::$is_initialized = true;
    }
}

