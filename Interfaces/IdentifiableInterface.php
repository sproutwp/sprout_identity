<?php
/**
 * @package Sprout
 * @subpackage SproutIdentity/Wrappers
 * @since 1.0.0
 */
namespace SproutIdentity\Interfaces;

/**
 * Interfaces that contains a single method in regards to an object's unique & persistent identity.
 *
 * @internal Mostly used by objects that are inside containers (as such, they're of the same intent, but differ) where comparison between these objects is needed.
 */
interface IdentifiableInterface
{
    /**
     * Retrieves the object's identifier.
     *
     * @internal Do note that this is the object identifier which is meant for identification in the broader scope. You might have a, say, "suggestion identifier" which is specific to the Suggestions Module.
     *
     * @return string
     */
    public function getUniqueObjectIdentifier();
}