<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/privacy/dlp/v2/storage.proto

namespace Google\Cloud\Dlp\V2\CustomInfoType;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Custom information type based on a dictionary of words or phrases. This can
 * be used to match sensitive information specific to the data, such as a list
 * of employee IDs or job titles.
 * Dictionary words are case-insensitive and all characters other than letters
 * and digits in the unicode [Basic Multilingual
 * Plane](https://en.wikipedia.org/wiki/Plane_%28Unicode%29#Basic_Multilingual_Plane)
 * will be replaced with whitespace when scanning for matches, so the
 * dictionary phrase "Sam Johnson" will match all three phrases "sam johnson",
 * "Sam, Johnson", and "Sam (Johnson)". Additionally, the characters
 * surrounding any match must be of a different type than the adjacent
 * characters within the word, so letters must be next to non-letters and
 * digits next to non-digits. For example, the dictionary word "jen" will
 * match the first three letters of the text "jen123" but will return no
 * matches for "jennifer".
 * Dictionary words containing a large number of characters that are not
 * letters or digits may result in unexpected findings because such characters
 * are treated as whitespace. The
 * [limits](https://cloud.google.com/dlp/limits) page contains details about
 * the size limits of dictionaries. For dictionaries that do not fit within
 * these constraints, consider using `LargeCustomDictionaryConfig` in the
 * `StoredInfoType` API.
 *
 * Generated from protobuf message <code>google.privacy.dlp.v2.CustomInfoType.Dictionary</code>
 */
class Dictionary extends \Google\Protobuf\Internal\Message
{
    protected $source;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Cloud\Dlp\V2\CustomInfoType\Dictionary\WordList $word_list
     *           List of words or phrases to search for.
     *     @type \Google\Cloud\Dlp\V2\CloudStoragePath $cloud_storage_path
     *           Newline-delimited file of words in Cloud Storage. Only a single file
     *           is accepted.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Privacy\Dlp\V2\Storage::initOnce();
        parent::__construct($data);
    }

    /**
     * List of words or phrases to search for.
     *
     * Generated from protobuf field <code>.google.privacy.dlp.v2.CustomInfoType.Dictionary.WordList word_list = 1;</code>
     * @return \Google\Cloud\Dlp\V2\CustomInfoType\Dictionary\WordList|null
     */
    public function getWordList()
    {
        return $this->readOneof(1);
    }

    public function hasWordList()
    {
        return $this->hasOneof(1);
    }

    /**
     * List of words or phrases to search for.
     *
     * Generated from protobuf field <code>.google.privacy.dlp.v2.CustomInfoType.Dictionary.WordList word_list = 1;</code>
     * @param \Google\Cloud\Dlp\V2\CustomInfoType\Dictionary\WordList $var
     * @return $this
     */
    public function setWordList($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Dlp\V2\CustomInfoType\Dictionary\WordList::class);
        $this->writeOneof(1, $var);

        return $this;
    }

    /**
     * Newline-delimited file of words in Cloud Storage. Only a single file
     * is accepted.
     *
     * Generated from protobuf field <code>.google.privacy.dlp.v2.CloudStoragePath cloud_storage_path = 3;</code>
     * @return \Google\Cloud\Dlp\V2\CloudStoragePath|null
     */
    public function getCloudStoragePath()
    {
        return $this->readOneof(3);
    }

    public function hasCloudStoragePath()
    {
        return $this->hasOneof(3);
    }

    /**
     * Newline-delimited file of words in Cloud Storage. Only a single file
     * is accepted.
     *
     * Generated from protobuf field <code>.google.privacy.dlp.v2.CloudStoragePath cloud_storage_path = 3;</code>
     * @param \Google\Cloud\Dlp\V2\CloudStoragePath $var
     * @return $this
     */
    public function setCloudStoragePath($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Dlp\V2\CloudStoragePath::class);
        $this->writeOneof(3, $var);

        return $this;
    }

    /**
     * @return string
     */
    public function getSource()
    {
        return $this->whichOneof("source");
    }

}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(Dictionary::class, \Google\Cloud\Dlp\V2\CustomInfoType_Dictionary::class);

