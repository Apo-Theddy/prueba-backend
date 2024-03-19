<?php

namespace usecase;

/**
 * @template R
 * @template P 
 */
interface IUsecase
{
  /**
   * @param P $params
   * @return R
   */
  public function call($params): mixed;
}
