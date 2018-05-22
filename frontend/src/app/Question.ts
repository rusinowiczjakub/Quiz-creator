import {Answer} from "./Answer";

export interface Question {
  id: number;
  content: string;
  answers: Array<Answer>;
}
