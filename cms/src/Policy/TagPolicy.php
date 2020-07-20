<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Tag;
use Authorization\IdentityInterface;

/**
 * Tag policy
 */
class TagPolicy
{
    /**
     * Check if $user can create Tag
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Tag $tag
     * @return bool
     */
    public function canCreate(IdentityInterface $user, Tag $tag)
    {
    }

    /**
     * Check if $user can update Tag
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Tag $tag
     * @return bool
     */
    public function canUpdate(IdentityInterface $user, Tag $tag)
    {
    }

    /**
     * Check if $user can delete Tag
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Tag $tag
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Tag $tag)
    {
        return $this->isAdmin($user);
    }

    /**
     * Check if $user can view Tag
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Tag $tag
     * @return bool
     */
    public function canView(IdentityInterface $user, Tag $tag)
    {
        return $this->isAdmin($user);
    }
    
    public function canAdd(IdentityInterface $user, Tag $tag)
    {
        return $this->isAdmin($user);
    }

    public function canEdit(IdentityInterface $user, Tag $tag)
    {
        return $this->isAdmin($user);
    }

    protected function isAdmin(IdentityInterface $user)
    {
        return $user->is_admin;
    }
}
