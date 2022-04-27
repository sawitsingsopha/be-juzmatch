<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/videointelligence/v1/video_intelligence.proto

namespace Google\Cloud\VideoIntelligence\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Video annotation response. Included in the `response`
 * field of the `Operation` returned by the `GetOperation`
 * call of the `google::longrunning::Operations` service.
 *
 * Generated from protobuf message <code>google.cloud.videointelligence.v1.AnnotateVideoResponse</code>
 */
class AnnotateVideoResponse extends \Google\Protobuf\Internal\Message
{
    /**
     * Annotation results for all videos specified in `AnnotateVideoRequest`.
     *
     * Generated from protobuf field <code>repeated .google.cloud.videointelligence.v1.VideoAnnotationResults annotation_results = 1;</code>
     */
    private $annotation_results;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Cloud\VideoIntelligence\V1\VideoAnnotationResults[]|\Google\Protobuf\Internal\RepeatedField $annotation_results
     *           Annotation results for all videos specified in `AnnotateVideoRequest`.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Videointelligence\V1\VideoIntelligence::initOnce();
        parent::__construct($data);
    }

    /**
     * Annotation results for all videos specified in `AnnotateVideoRequest`.
     *
     * Generated from protobuf field <code>repeated .google.cloud.videointelligence.v1.VideoAnnotationResults annotation_results = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getAnnotationResults()
    {
        return $this->annotation_results;
    }

    /**
     * Annotation results for all videos specified in `AnnotateVideoRequest`.
     *
     * Generated from protobuf field <code>repeated .google.cloud.videointelligence.v1.VideoAnnotationResults annotation_results = 1;</code>
     * @param \Google\Cloud\VideoIntelligence\V1\VideoAnnotationResults[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setAnnotationResults($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Cloud\VideoIntelligence\V1\VideoAnnotationResults::class);
        $this->annotation_results = $arr;

        return $this;
    }

}

