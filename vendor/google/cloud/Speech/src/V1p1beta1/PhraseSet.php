<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/speech/v1p1beta1/resource.proto

namespace Google\Cloud\Speech\V1p1beta1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Provides "hints" to the speech recognizer to favor specific words and phrases
 * in the results.
 *
 * Generated from protobuf message <code>google.cloud.speech.v1p1beta1.PhraseSet</code>
 */
class PhraseSet extends \Google\Protobuf\Internal\Message
{
    /**
     * The resource name of the phrase set.
     *
     * Generated from protobuf field <code>string name = 1;</code>
     */
    private $name = '';
    /**
     * A list of word and phrases.
     *
     * Generated from protobuf field <code>repeated .google.cloud.speech.v1p1beta1.PhraseSet.Phrase phrases = 2;</code>
     */
    private $phrases;
    /**
     * Hint Boost. Positive value will increase the probability that a specific
     * phrase will be recognized over other similar sounding phrases. The higher
     * the boost, the higher the chance of false positive recognition as well.
     * Negative boost values would correspond to anti-biasing. Anti-biasing is not
     * enabled, so negative boost will simply be ignored. Though `boost` can
     * accept a wide range of positive values, most use cases are best served with
     * values between 0 (exclusive) and 20. We recommend using a binary search
     * approach to finding the optimal value for your use case. Speech recognition
     * will skip PhraseSets with a boost value of 0.
     *
     * Generated from protobuf field <code>float boost = 4;</code>
     */
    private $boost = 0.0;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $name
     *           The resource name of the phrase set.
     *     @type \Google\Cloud\Speech\V1p1beta1\PhraseSet\Phrase[]|\Google\Protobuf\Internal\RepeatedField $phrases
     *           A list of word and phrases.
     *     @type float $boost
     *           Hint Boost. Positive value will increase the probability that a specific
     *           phrase will be recognized over other similar sounding phrases. The higher
     *           the boost, the higher the chance of false positive recognition as well.
     *           Negative boost values would correspond to anti-biasing. Anti-biasing is not
     *           enabled, so negative boost will simply be ignored. Though `boost` can
     *           accept a wide range of positive values, most use cases are best served with
     *           values between 0 (exclusive) and 20. We recommend using a binary search
     *           approach to finding the optimal value for your use case. Speech recognition
     *           will skip PhraseSets with a boost value of 0.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Speech\V1P1Beta1\Resource::initOnce();
        parent::__construct($data);
    }

    /**
     * The resource name of the phrase set.
     *
     * Generated from protobuf field <code>string name = 1;</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * The resource name of the phrase set.
     *
     * Generated from protobuf field <code>string name = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setName($var)
    {
        GPBUtil::checkString($var, True);
        $this->name = $var;

        return $this;
    }

    /**
     * A list of word and phrases.
     *
     * Generated from protobuf field <code>repeated .google.cloud.speech.v1p1beta1.PhraseSet.Phrase phrases = 2;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getPhrases()
    {
        return $this->phrases;
    }

    /**
     * A list of word and phrases.
     *
     * Generated from protobuf field <code>repeated .google.cloud.speech.v1p1beta1.PhraseSet.Phrase phrases = 2;</code>
     * @param \Google\Cloud\Speech\V1p1beta1\PhraseSet\Phrase[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setPhrases($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Cloud\Speech\V1p1beta1\PhraseSet\Phrase::class);
        $this->phrases = $arr;

        return $this;
    }

    /**
     * Hint Boost. Positive value will increase the probability that a specific
     * phrase will be recognized over other similar sounding phrases. The higher
     * the boost, the higher the chance of false positive recognition as well.
     * Negative boost values would correspond to anti-biasing. Anti-biasing is not
     * enabled, so negative boost will simply be ignored. Though `boost` can
     * accept a wide range of positive values, most use cases are best served with
     * values between 0 (exclusive) and 20. We recommend using a binary search
     * approach to finding the optimal value for your use case. Speech recognition
     * will skip PhraseSets with a boost value of 0.
     *
     * Generated from protobuf field <code>float boost = 4;</code>
     * @return float
     */
    public function getBoost()
    {
        return $this->boost;
    }

    /**
     * Hint Boost. Positive value will increase the probability that a specific
     * phrase will be recognized over other similar sounding phrases. The higher
     * the boost, the higher the chance of false positive recognition as well.
     * Negative boost values would correspond to anti-biasing. Anti-biasing is not
     * enabled, so negative boost will simply be ignored. Though `boost` can
     * accept a wide range of positive values, most use cases are best served with
     * values between 0 (exclusive) and 20. We recommend using a binary search
     * approach to finding the optimal value for your use case. Speech recognition
     * will skip PhraseSets with a boost value of 0.
     *
     * Generated from protobuf field <code>float boost = 4;</code>
     * @param float $var
     * @return $this
     */
    public function setBoost($var)
    {
        GPBUtil::checkFloat($var);
        $this->boost = $var;

        return $this;
    }

}
