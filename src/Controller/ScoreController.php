<?php

namespace App\Controller;

use App\Entity\IssueResult;
use App\Repository\IssueResultRepository;
use App\Repository\ScoreRepository;
use App\Service\GitHubService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ScoreController extends AbstractController
{
    #[Route(path:'/api/v1/terms', name:'gitTerms', methods: ['GET'])]
    public function findGitGubIssue(
        Request $request,
        ScoreRepository $scoreRepository,
        GitHubService $gitHubService,
        ValidatorInterface $validator,
        IssueResultRepository $issueResultRepository
    ): Response
    {
        $errors = $validator->validate($request->get('q'), [
            new NotNull(),
            new NotBlank()
        ]);

        $term = $request->get('q');

        if (0 !== count($errors)) {
            return $this->json('No params', 400);
        }

        $termObject = $issueResultRepository->findOneBy(['term' => $term]);

        if (!isset($termObject)) {
            $scoreRepository->setService($gitHubService);

            $score = $scoreRepository->searchData($term);

            if (!$score) {
                return $this->json('Nothing was found', 404);
            }

            $termObject = new IssueResult();
            $termObject->setTerm($term);
            $termObject->setScore($score);

            $issueResultRepository->add($termObject, true);
        }

        return $this->json([
            'term' => $termObject->getTerm(),
            'score' => $termObject->getScore()
        ]);
    }
}