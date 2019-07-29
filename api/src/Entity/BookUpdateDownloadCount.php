<?php

// api/src/Entity/ResetPasswordRequest.php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     messenger=true,
 *     collectionOperations={
 *         "post"={"status"=202}
 *     },
 *     itemOperations={},
 *     output=false
 * )
 */
final class BookUpdateDownloadCount
{
    /**
     * @var integer
     *
     * @Assert\NotBlank
     */
    public $book_id;

}