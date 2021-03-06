<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Article;
use Authorization\IdentityInterface;

/**
 * Article policy
 */
class ArticlePolicy
{
    /**
     * Check if $user can create Article
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Article $article
     * @return bool
     */
    public function canCreate(IdentityInterface $user, Article $article)
    {
    }

    /**
     * Check if $user can update Article
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Article $article
     * @return bool
     */
    public function canUpdate(IdentityInterface $user, Article $article)
    {
    }

    /**
     * Check if $user can delete Article
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Article $article
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Article $article)
    {
        if($this->isAdmin($user, $article)) {
            return true;
        } else {
            return $this->isAuthor($user, $article);
        }
    }

    /**
     * Check if $user can view Article
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Article $article
     * @return bool
     */
    public function canView(IdentityInterface $user, Article $article)
    {
    }
    
    public function canAdd(IdentityInterface $user, Article $article)
    {
        // All logged in users can create articles.
        return true;
    }

    public function canEdit(IdentityInterface $user, Article $article)
    {
        // normal users can edit their own articles. while admin user can edit all
        if($this->isAdmin($user, $article)) {
            return true;
        } else {
            return $this->isAuthor($user, $article);
        }
    }

    protected function isAuthor(IdentityInterface $user, Article $article)
    {
        return $article->user_id === $user->getIdentifier();
    }

    protected function isAdmin(IdentityInterface $user, Article $article)
    {
        return $user->is_admin;
    }
}
