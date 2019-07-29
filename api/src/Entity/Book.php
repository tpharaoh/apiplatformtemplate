<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use App\Controller\BookGetCollectionController;
use App\Controller\BookPostCollectionController;
use App\Controller\BookPutCollectionController;

/**
 * Book
 *
 * @ORM\Table(name="book")
 * @ORM\Entity(repositoryClass="App\Repository\BookRepository")
 * @ApiResource(
 *     mercure="object.getTeam().getMercureIri()",
 *     attributes={
 *          "normalization_context"={
 *              "groups"={"book_read"}
 *          },
 *          "denormalization_context"={
 *              "groups"={"book_write"}
 *          },
 *          "order"={"id": "DESC"}
 *     },
 *     collectionOperations={
 *          "get"={
 *              "method"="GET",
 *              "path"="/books",
 *              "controller"=BookGetCollectionController::class,
 *              "defaults"={"_api_receive"=false},
 *          },
 *          "post"={
 *              "method"="POST",
 *              "path"="/books",
 *              "controller"=BookPostCollectionController::class,
 *              "defaults"={"_api_receive"=true},
 *          }
 *     },
 *     itemOperations={
 *          "get"={
 *              "access_control"="object.getTeam() == user.getTeam()"
 *          },
 *          "put"={
 *              "access_control"="object.getOwner() == user",
 *              "controller"=BookPutCollectionController::class,
 *          },
 *          "delete"={
 *              "access_control"="object.getOwner() == user"
 *          }
 *     })
 */
class Book
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({
     *     "book_read",
     * })
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Groups({
     *     "book_read",
     *     "book_write",
     * })
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Groups({
     *     "book_read",
     *     "book_write",
     * })
     * @Assert\NotBlank()
     */
    private $author;

    /**
     * @ORM\Column(type="integer", nullable=false)
     * @Groups({
     *     "book_read",
     *     "book_write",
     * })
     */
    private $downloadCount;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Team")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({
     *     "book_read",
     * })
     * @Assert\NotNull()
     */
    private $team;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({
     *     "book_read",
     * })
     * @Assert\NotNull()
     */
    private $owner;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): self
    {
        $this->team = $team;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getDownloadCount(): ?int
    {
        return $this->downloadCount;
    }

    public function setDownloadCount(?int $downloadCount): self
    {
        $this->downloadCount = $downloadCount;

        return $this;
    }
}
