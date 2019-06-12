<?php
/**
 * @package Sprout
 * @subpackage SproutIdentity/Wrappers
 * @since 1.0.0
 */
namespace Sprout\SproutIdentity\Wrappers;

use Sprout\SproutIdentity\ArrayIdentity;

final class IdentityWrappers
{
    /**
     * Determines whether the old indeity of a target is still relevant.
     *
     * Example: If you generated the output of 50 suggestions and they have an identity as a collection but now we ask "is there
     * a new member or did any members change?", this function builds the identity again and checks it against the older identity, in essence, performing
     * an "are there are changes in this collection of objects?" check.
     *
     * This is used when you have a huge list of objects that you traverse through and they generate some kind of output. Now,
     * imagine how many resources it'll take to re-compute all that output on every request, especially if the issue is of bandwidth.
     * Build the identity and use the database as a storage.
     *
     * @internal Sprout\SproutServices\Bridges\ServiceDataBridge::createServiceToDataBridge allows you to create the persistence of data as well as hook it to a cleaner.
     *
     * @param array $for The array of objects.
     * @param string $check_against The past identity name.
     * @return boolean Returns false if the identity doesn't match (so a new object entered the collective or an object in the collective was changed) and true if it does (no new changes in the collection).
     */
    public static function isIdentityStillRelevant( $for, $check_against )
    {
        $identity = ArrayIdentity::computeArrayIndetity( $for );

        /**
         * What if we create a cache that draws the initial data from the database and
         * for the duration of the request, it queries that cache and at the end of the request,
         * it updates the database in one shot, instead of making multiple requests.
         */
        $stored_identities = get_option( 'sprout_identities', [] );

        if( !isset( $stored_identities[$check_against] ) ) {
            $stored_identities[$check_against] = '';
        }

        if( $identity != $stored_identities[$check_against] ) {
            $stored_identities[$check_against] = $identity;
            update_option( 'sprout_identities', $stored_identities, 'yes' );
            return False;
        }

        return True;
    }
}